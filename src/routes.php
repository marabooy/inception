<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 12:48 PM
 */


Route::after(function($request, $response){
    $response->headers->set('Access-Control-Allow-Origin', '*');
    return $response;

});
Route::controller('search','Marabooyankee\Inception\Controllers\SearchController');
Route::get('playback/{id}','Marabooyankee\Inception\Controllers\DocumentsController@getPlayBack');
Route::get('playback/{id}','Marabooyankee\Inception\Controllers\DocumentsController@getPlayBack');
Route::controller('/documents','Marabooyankee\Inception\Controllers\DocumentsController');
Route::controller('/','Marabooyankee\Inception\Controllers\DocumentsController');

