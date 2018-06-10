<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//news routes
Route::get('news', 'NewsController@index');
Route::get('news/{id}', 'NewsController@renderNewsStory');

//events routes
Route::get('events', 'EventsController@index');
Route::get('events/{id}', 'EventsController@renderEventDetails');

//tracking routes
Route::get('tracking', 'TrackingController@index');

//can just have one route since we use the same function
Route::post('/trackVisit', 'TrackingController@trackVisit');
Route::post('events/trackVisit', 'TrackingController@trackVisit');
Route::post('news/trackVisit', 'TrackingController@trackVisit');

Route::get('tracking/csvSummary', 'TrackingController@exportCSV');
