<?php

class Place extends \App\Mvc\Model
{
    public $id;
    public $factual_id;
    public $name;
    public $address;
    public $address_extended;
    public $locality;
    public $region;
    public $postcode;
    public $country;
    public $tel;
    public $website;
    public $latitude;
    public $longitude;
    public $hours;
    public $category_labels;
    public $category_ids;
    public $email;
    public $po_box;

    /**
     *
     * Defines database table to use
     *
     * @return null
     */
    public function getSource()
    {
        return 'place';
    }

    /**
     *
     * Defines API mapping for column names
     *
     * @return null
     */
    public function columnMap()
    {
        return [
            'id' => 'id',
            'factual_id' => 'factual_id',
            'name' => 'name',
            'address' => 'address',
            'address_extended' => 'address_extended',
            'locality' => 'locality',
            'region' => 'region',
            'postcode' => 'postcode',
            'country' => 'country',
            'tel' => 'tel',
            'website' => 'website',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
            'hours' => 'hours',
            'category_labels' => 'category_labels',
            'category_ids' => 'category_ids',
            'email' => 'email',
            'po_box' => 'po_box',
            'updated_at' => 'updated_at',
            'created_at' => 'created_at',
        ];
    }

    /**
     *
     * Defines which columns can be displayed
     *
     * @return null
     */
    public function whitelist()
    {
        return [
            'name',
            'address',
            'address_extended',
            'locality',
            'region',
            'postcode',
            'country',
            'tel',
            'website',
            'hours',
            'latitude',
            'longitude'
        ];
    }

    /**
     *
     * Defines Validation Rules
     *
     * @TODO test existing validations (max, min..) and create new required ones (between, etc...)
     * @return null
     */
    public function validateRules()
    {
        return [
            'name' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
    }
}