<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/7/2014
 * Time: 1:17 PM
 */

namespace Marabooyankee\Inception\Converters;


class GeoJson2ElasticDocument extends Csv2GeoJson{

    public function toArray()
    {
        return array(
            'type' => 'Feature',
            'geometry' => array(
                'type' => 'linestring',
                'coordinates' => $this->coordinates
            ),
            'properties' => $this->properties
        );
    }
} 