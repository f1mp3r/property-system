<?php

namespace App\Mappers\Property;

class PropertySyncMapper
{
    public static function toLocal($data): array
    {
        return [
            'remote_uuid' => $data->uuid,
            'county' => $data->county,
            'country' => $data->country,
            'town' => $data->town,
            'description' => $data->description,
            'address' => $data->address,
            'image_url' => $data->image_full,
            'thumbnail_url' => $data->image_thumbnail,
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'bedrooms' => $data->num_bedrooms,
            'bathrooms' => $data->num_bathrooms,
            'price' => $data->price,
            'type' => $data->type,
            'property_type' => $data->property_type,
        ];
    }
}
