<?php

use League\Fractal;

class PlaceTransformer extends Fractal\TransformerAbstract
{
    /**
     * Turns this resource object into a generic array
     *
     * @var \Place $place The place to transform
     * @return array
     */
    public function transform(\Place $place)
    {
        return [
            'id' => (int) $place->id,
            'name' => $place->name,
            'address' => $place->address,
            'address_extended' => $place->address_extended,
            'locality' => $place->locality,
            'region' => $place->region,
            'postcode' => $place->postcode,
            'country' => $place->country,
            'tel' => $place->tel,
            'website' => $place->website,
            'hours' => $place->hours,
            'latitude' => $place->latitude,
            'longitude' => $place->longitude,
            'created_at' => (int) strtotime($place->created_at) * 1000,
            'updated_at' => (int) strtotime($place->updated_at) * 1000,
        ];
    }
}
