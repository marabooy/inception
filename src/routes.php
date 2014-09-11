<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 12:48 PM
 */



Route::controller('search','Marabooyankee\Inception\Controllers\SearchController');
Route::get('playback/{id}','Marabooyankee\Inception\Controllers\DocumentsController@getPlayBack');
Route::controller('/','Marabooyankee\Inception\Controllers\DocumentsController');

