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

Route::get('/', function () {
    return view('/dashboard');
})->middleware('auth');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('/map/search', 'MapController@search')->name('map.search');
Route::get('/map/upload', 'MapController@upload')->name('map.upload');
Route::get('/map/action', 'MapController@action')->name('map.action');
Route::get('/map/google', 'MapController@google')->name('map.google');
Route::post('/map/pitch', 'MapController@pitch')->name('map.pitch');
Route::post('/map/measure_google', 'MapController@measure_google')->name('map.measure_google');
Route::post('/map/measure_near', 'MapController@measure_near')->name('map.measure_near');
Route::post('/map/real', 'MapController@real')->name('map.real');
Route::post('/map/user_upload', 'MapController@user_upload')->name('map.user_upload');
Route::post('/map/download', 'MapController@download')->name('map.download');
Route::resource('map', 'MapController');