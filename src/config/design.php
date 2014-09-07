<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 6:33 PM
 */

/**
 * Contains views for the couch db design docs
 * <code>
 *  array(
 *    array(
 *      "name" => array(
 *          "map"     => "code",
 *          ["reduce" => "code"],
 *      ),
 *      ...
 *    )
 *  )
 * </code>
 */

return array(

    array(
        "geo_index"=>array(
            "index"=>'
                function (doc) {


                    if (doc.geometry) {
                        st_index(do.geometry);
                    }
                }',
        ),

    )


);