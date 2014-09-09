<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/7/2014
 * Time: 9:36 PM
 */

namespace Marabooyankee\Inception\Controllers;


use Elasticsearch\Client;
use Illuminate\Routing\Controller;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;

class SearchController extends Controller
{
    /**@var \Elasticsearch\Client $client */
    protected $client;

    public function __construct(Client $client)
    {

        $this->client = $client;
    }

    public function postIndex()
    {
        $boundingBox = \Input::all();
        $lats = [$boundingBox[0][1], $boundingBox[1][1]];
        $maxLat = max($lats);
        $minLat = min($lats);

        $lngs = [$boundingBox[0][0], $boundingBox[1][0]];
        $maxLng = max($lngs);
        $minLng = min($lngs);

        $shapDimenstions = [
            [$maxLng, $maxLat],
            [$minLng, $minLat]];

        $shape = [
            "type" => "envelope",
            "coordinates" => $shapDimenstions
        ];

        $query = [
            "_source" => false,
            "query" => [
                "filtered" => [
                    "query" => [
                        "match_all" => new \stdClass()
                    ]
                    ,
                    "filter" => [
                        "geo_shape" => [
                            "geometry" => [
                                "shape" => $shape
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $param = [
            'index' => 'csv_dump',
            'type' => 'csv',
            'body' => $query
        ];

//        return $param['body'];
        return $this->client->search($param);
    }

    public function getDocument($type, $id)
    {
        $index = array('index' => 'csv_dump', 'type' => $type, 'id' => $id);

        $document = (array)$this->client->get($index);

        $props = $document['_source']['properties'];
        $dims = array_keys($props);

        $dimLength = count($props[$dims[0]]);

        $userDims = array();

        for ($i = 0; $i < $dimLength; $i++) {
            $row = array();

            foreach ($dims as $dim) {
                $row[$dim]=$props[$dim][$i];
            }
            array_push($userDims,$row);
        }

        return $userDims;


    }
} 