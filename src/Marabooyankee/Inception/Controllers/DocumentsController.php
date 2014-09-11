<?php namespace Marabooyankee\Inception\Controllers;


use Elasticsearch\Client;
use League\Csv\Reader;

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

    public function getIndex()
    {
        return \View::make('inception::visualization.dashboard');
    }

    public function getPLayBack($id)
    {
        /**@var Client $elasticClient */
        $elasticClient = app('inception:elastic-client');

        $geoJson = $elasticClient->get(['index'=>'csv_dump','type'=>'csv','id'=>$id]);

//        return $getGeoJson;
        return \View::make('inception::visualization.playback')->with(compact('geoJson'));
    }
} 