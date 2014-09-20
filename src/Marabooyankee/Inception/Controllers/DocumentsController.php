<?php namespace Marabooyankee\Inception\Controllers;


use Elasticsearch\Client;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 12:31 PM
 */
class DocumentsController extends \Illuminate\Routing\Controller
{

    protected $cachedQuery = array();

    public function __construct()
    {
        $this->cachedQuery = [
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
                                "shape" => array()
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public function getInception()
    {
        return \View::make('inception::interactive');
    }

    public function getIndex()
    {
        return \View::make('inception::visualization.dashboard');
    }



    public function getPLayBack($id)
    {
        /**@var Client $elasticClient */
        $elasticClient = app('inception:elastic-client');

        $geoJson = $elasticClient->get(['index' => 'csv_dump', 'type' => 'csv', 'id' => $id]);

//        return $getGeoJson;
        return \View::make('inception::visualization.playback')->with(compact('geoJson'));
    }


    public function getFindVideos($id)
    {

        $streamedResponse = \Response::stream(function () use ($id) {

            /**
             * "indexed_shape": {
             * "id":"e4d2CLHmRhqoa-xQQ1ow8w",
             * "type":"csv",
             * "index":"csv_dump",
             * "path":"geometry"
             * }
             */
            $shape = [
                'indexed_shape' => [
                    'id' => $id,
                    'type' => 'csv',
                    'index' => 'csv_dump',
                    'path' => 'geometry'
                ]
            ];

            $query = $this->cachedQuery;


            array_set($query, 'query.filtered.filter.geo_shape.geometry', $shape);

            $elasticClient = app('inception:elastic-client');
            $param = [
                'index' => 'csv_dump',
                'type' => 'video',
                'body' => $query
            ];

//        return $query;
            echo json_encode($elasticClient->search($param)).PHP_EOL;

            ob_flush();
            flush();
        });

        return $streamedResponse;


    }
} 