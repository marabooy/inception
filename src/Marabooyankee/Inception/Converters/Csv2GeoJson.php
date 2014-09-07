<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 4:44 PM
 */

namespace Marabooyankee\Inception\Converters;


use League\Csv\Reader;

class Csv2GeoJson
{
    /**
     * @var Reader reader
     */
    protected $reader;
    /**
     * contains the coordinates part of the geojson in this case a multipoint specification
     * @var array
     */
    protected $coordinates = array();
    /**
     * contains a hashmap of the values and
     * @var array
     */
    protected $properties = array();
    /**
     * @var array
     */
    protected $propertyIndexes;
    /**
     * @var array
     */
    protected $propertyNames;
    /**
     * Long  Lat pairs
     * @var array
     */
    protected $locationIndexes;

    /**
     * loaction indexes should have long lat
     * @param Reader $reader
     * @param array $propertyIndexes
     * @param array $propertyNames
     * @param array $locationIndexes
     */
    public function __construct(Reader $reader, array $propertyIndexes, array $propertyNames, array $locationIndexes)
    {
        $this->reader = $reader;
        $this->propertyIndexes = $propertyIndexes;
        $this->propertyNames = $propertyNames;
        $this->locationIndexes = $locationIndexes;
    }

    public function convert()
    {
        //skip first 2 rows
        $this->reader->setOffset(2);

        $this->reader->each(function ($row, $index, $iterator) {
            $this->extractCoordinates($row);
            $this->extractProperties($row);
            return true;
        });

        print_r(count($this->coordinates));


    }


    public function extractCoordinates($row)
    {
        $lng = $row[$this->locationIndexes[0]];
        $lat = $row[$this->locationIndexes[1]];
        array_push($this->coordinates, [$lng, $lat]);
    }

    public function extractProperties($row)
    {
        foreach ($this->propertyIndexes as $key => $value) {
            $propertyName = $this->propertyNames[$key];
            if (!isset($this->properties[$propertyName])) {
                $this->properties[$propertyName] = array();
            }
            array_push($this->properties[$propertyName], $row[$value]);
        }
    }

    public function toArray()
    {
        return array(
            'type' => 'Feature',
            'geometry' => array(
                'type' => 'multipoint',
                'coordinates' => $this->coordinates
            ),
            'properties' => $this->properties
        );
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }
} 