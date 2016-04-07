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
     * @description("Find places by name and type")
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
        // Searches for latitude and longitude details using GOOGLE GEOCODE API
        // TODO

        // Searches for places on the FACTUAL API
        // TODO Change below to get specific categories and proximity GET settings
        $factual = new Factual("get-key-from-config","get-secret-from-config");
        $query = new FactualQuery;
        $query->search("Sushi Bondi");
        $res = $factual->fetch("places", $query);
        $factual_results = $res->getData();

        // Loads results into the Place Model
        $places = array();
        if(sizeof($factual_results)){
            $place = new Place();
            $place->factual_id = $factual_results['factual_id'];
            $place->name = $factual_results['name'];
            $place->address = $factual_results['address'];
            $place->address_extended = $factual_results['address_extended'];
            $place->locality = $factual_results['locality'];
            $place->region = $factual_results['region'];
            $place->postcode = $factual_results['postcode'];
            $place->country = $factual_results['country'];
            $place->tel = $factual_results['tel'];
            $place->website = $factual_results['website'];
            $place->latitude = $factual_results['latitude'];
            $place->longitude = $factual_results['longitude'];
            $place->hours = $factual_results['hours'];
            $place->category_labels = $factual_results['category_labels'];
            $place->category_ids = $factual_results['category_ids'];
            $place->email = $factual_results['email'];
            $place->po_box = $factual_results['po_box'];
            $places[] = $place;
        }

        // Produces results
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
        // TODO

        // 1- Define a points system from 0 to 5

        // 2- Map likes and dislikes to the points definition

        // 3- Add requirements to the query ("glutten free")

        // 4- Search for places with the best score (max points)

    }

}
