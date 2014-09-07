<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 6:31 PM
 */

namespace Marabooyankee\Inception\Design;


use Doctrine\CouchDB\View\DesignDocument;

class CouchViews implements  DesignDocument{

    /**
     * Get design doc code
     *
     * Return the view (or general design doc) code, which should be
     * committed to the database, which should be structured like:
     *
     * <code>
     *  array(
     *    "views" => array(
     *      "name" => array(
     *          "map"     => "code",
     *          ["reduce" => "code"],
     *      ),
     *      ...
     *    )
     *  )
     * </code>
     */
    public function getData()
    {

        return array(
            "views"=>\Config::get('inception::design')
        );

    }
}