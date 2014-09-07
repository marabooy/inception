<?php namespace Marabooyankee\Inception\Controllers;


use League\Csv\Reader;

/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 12:31 PM
 */
class DocumentsController extends \Illuminate\Routing\Controller
{


    public function getIndex()
    {

    }

    public function postDocument()
    {
        $client = \Doctrine\CouchDB\CouchDBClient::create(\Config::get('inception::config'));


    }
} 