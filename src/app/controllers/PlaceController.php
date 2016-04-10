<?php

use PhalconRest\Constants\ErrorCodes as ErrorCodes;
use PhalconRest\Exceptions\UserException;

/**
 * @resource("Place")
 */
class PlaceController extends \App\Mvc\Controller
{
    /**
     * @title("Search")
     * @description("Find 5 closest places by name and type")
     * @response("Place objects or Error object")
     * @requestExample("GET /places/search?location=Woolloomooloo&type=coffee")
     * @responseExample({
     *     "place": {
     *         "name": "Manly Cafe",
     *         "address": "33 Herald St, Manly 2018",
     *         ...
     *     },
     *     ...
     * })
     */
    public function search()
    {

        // Receives requested params
        $search_type = preg_replace('#[^A-Za-z0-9-./]#', '', $_GET['type']);
        $search_location = preg_replace('#[^A-Za-z0-9-./]#', '', $_GET['location']);

        // Performs the search
        $search_results = false;
        if($search_type && $search_location){
            $search_results = $this->placeService->search($search_location, $search_type);
        }

        // Loads results into place objects
        $places = array();
        if($search_results){
            foreach($search_results as $result){
                $place = new Place();
                $place->setFactualValues($result);
                $places[] = $place;
            }
        }

        // Returns results to the api client
        return $this->respondCollection($places, new PlaceTransformer(), 'places');
    }

    /**
     * @title("Recommendations")
     * @description("Recommend places for a group of people with distinct interests")
     * @response("Place objects or Error object")
     * @requestExample("POST /places/recommendations")
     * @responseExample({
     *     "place": {
     *         "name": "Manly Cafe",
     *         "address": "33 Herald St, Manly 2018",
     *         ...
     *     },
     *     ...
     * })
     */
    public function recommendations()
    {

        // Gets posted data with the group preferences
        $raw_post_json = file_get_contents("php://input");
        $group_preferences = json_decode($raw_post_json, true);

        // Receives location
        $search_location = preg_replace('#[^A-Za-z0-9-./]#', '', $_GET['location']);

        // Performs the search
        $search_results = false;
        if($group_preferences && $search_location){
            $options = array('meal_lunch' => true, 'radius' => 5000);
            $search_results = $this->placeService->recommend($search_location, $group_preferences, $options);
        }

        // Loads results into place objects
        $places = array();
        if($search_results){
            foreach($search_results as $result){
                $place = new Place();
                $place->setFactualValues($result);
                $places[] = $place;
            }
        }

        // Returns results to the api client
        return $this->respondCollection($places, new PlaceTransformer(), 'places');

    }

}
