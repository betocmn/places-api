<?php

namespace App\Services;

use App\Constants\Services as AppServices;
use Phalcon\Di;
use Factual;
use FactualQuery;
use FactualCircle;

class PlaceService extends \PhalconRest\Mvc\Plugin
{
    protected $geocoder = false;
    protected $factual = false;

    /**
     * Sets up 3rd party libraries
     *
     */
    public function __construct()
    {

        // Sets up Google Geocoder object
        $this->geocoder = new \Geocoder\Provider\GoogleMaps(
            new \Ivory\HttpAdapter\CurlHttpAdapter(),
            $this->config->googleGeocodeApi->locale,
            $this->config->googleGeocodeApi->region,
            $this->config->googleGeocodeApi->ssl
        );

        // Sets up Factual API object
        $this->factual = new Factual($this->config->factualApi->key, $this->config->factualApi->secret);
    }

    /**
     *
     * Searches for the closest bars/cafes/restaurants from
     * the given location of the given type
     *
     * @param String[Required] $location
     * @param String[Required] $type
     * @param Array[Optional] $options
     * @return array Factual results
     */
    public function search($location, $type, $options = array())
    {

        // Defines default options
        if(!isset($options['limit'])){
            $options['limit'] = 5;
        }
        if(!isset($options['radius'])){
            $options['radius'] = 15000; //meters
        }

        // Get latitude and longitude from address/name
        $results = false;
        $geocode = $this->geocode($location);
        if($geocode){

            // Searches on Factual API
            $query = new FactualQuery;
            $query->field("category_ids")->in($this->config->factualApi->categories);
            $query->limit($options['limit']);
            $query->field("cuisine")->search($type);
            if(isset($options['meal_lunch']) && $options['meal_lunch']){
                $query->field("meal_lunch")->equal(true);
            }
            if(isset($options['options_glutenfree']) && $options['options_glutenfree']){
                $query->field("options_glutenfree")->equal(true);
            }
            $query->within(new FactualCircle($geocode['latitude'], $geocode['longitude'], $options['radius']));
            $query->sortAsc("\$distance");
            $results = $this->factual->fetch("restaurants-au", $query);

        }
        return $results;
    }

    /**
     *
     * Converts an address to latitude and longitude
     *
     * @param String[Required] $address
     * @return mixed (array on success, false on failure)
     */
    public function geocode($address){

        $addresses = $this->geocoder->limit(1)->geocode($address);
        if($addresses){
            return array(
                'latitude' => $addresses->first()->getLatitude(),
                'longitude' => $addresses->first()->getLongitude()
            );
        }

        return false;

    }

    /**
     *
     * Recommends the best 5 places based on the preferences of a group
     *
     * @param String[Required] $location
     * @param Array[Required] $preferences
     * @param Array[Optional] $options
     * @return array Factual results
     */
    public function recommend($location, $preferences, $options)
    {

        // Defines a rating system from 0 to 5
        $points_dislike = 0;
        $points_like = 5;
        $points_default = 3;
        $gluten_free = false;

        // Builds a list of all unique cuisines mentioned and calculates points accordingly to likes/dislikes
        $cuisines = array();
        $total_ratings = 0;
        foreach($preferences as $worker){
            $like_cuisines = array();
            foreach($worker['likes'] as $cuisine){
                if(!in_array($cuisine, $like_cuisines)){
                    if(!isset($cuisines[$cuisine])){
                        $cuisines[$cuisine]['total_ratings'] = 0;
                        $cuisines[$cuisine]['total_score'] = 0;
                        $cuisines[$cuisine]['total_dislikes'] = 0;
                    }
                    $cuisines[$cuisine]['total_ratings']++;
                    $cuisines[$cuisine]['total_score'] += $points_like;
                    $like_cuisines[] = $cuisine;
                }
            }
            $dislike_cuisines = array();
            foreach($worker['dislikes'] as $cuisine){
                if(!in_array($cuisine, $dislike_cuisines)){
                    if(!isset($cuisines[$cuisine])){
                        $cuisines[$cuisine]['total_ratings'] = 0;
                        $cuisines[$cuisine]['total_score'] = 0;
                        $cuisines[$cuisine]['total_dislikes'] = 0;
                    }
                    $cuisines[$cuisine]['total_ratings']++;
                    $cuisines[$cuisine]['total_score'] += $points_dislike;
                    $cuisines[$cuisine]['total_dislikes']++;
                    $dislike_cuisines[] = $cuisine;
                }
            }
            if(isset($group_preferences['requirements']) && $group_preferences['requirements'] == "gluten free"){
                $gluten_free = true;
            }
            $total_ratings++;
        }

        // All cuisines that were not mentioned should get the default number of points
        $final_cuisines = array();
        foreach($cuisines as $key => $cuisine){
            if($cuisine['total_ratings'] < $total_ratings){
                $missing_ratings = $total_ratings - $cuisine['total_ratings'];
                $cuisine['total_ratings'] += $missing_ratings;
                $cuisine['total_score'] += $missing_ratings * $points_default;
            }
            $final_cuisines[$key] = $cuisine['total_score'];
        }

        // Sort cuisine by points
        arsort($final_cuisines);

        // Performs factual search untils results are found
        $results = false;
        $options['options_glutenfree'] = $gluten_free;
        while($current = current($final_cuisines)) {
            $results = $this->search($location, key($final_cuisines), $options);
            if($results->isEmpty()){
                $results = false;
            } else {
                break;
            }
            next($final_cuisines);
        }

        // If still no results and gluten free option is true, we try to search without it
        if(!$results && $options['options_glutenfree'] == true){
            $options['options_glutenfree'] = false;
            reset($final_cuisines);
            while($current = current($final_cuisines)) {
                $results = $this->search($location, key($final_cuisines), $options);
                if($results->isEmpty()){
                    $results = false;
                } else {
                    break;
                }
                next($final_cuisines);
            }
        }

        // returns factual search results
        return $results;
    }
}
