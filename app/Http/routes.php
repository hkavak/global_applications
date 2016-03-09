<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
/*

 * 
 */
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */
Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');
    Route::get('application_form', 'PageController@home');
    Route::post('application_form', 'PageController@postButton');

    Route::group(['middleware' => 'admin'], function() {

        Route::get('check_application', 'checkController@start');
        Route::post('check_application', 'checkController@postButton');
        Route::get('status_application', 'StatusController@start');
        Route::post('status_application', 'StatusController@postButton');
        Route::get('pdf', 'StatusController@convertPDF');
    });
});
