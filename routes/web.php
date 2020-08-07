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

Route::get('/login', function () {
    return view('/dashboard');
})->middleware('auth');

Route::get('/', function () {
    return view('/landing');
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/profile', 'ProfileController@index');

Route::post('/map/search', 'MapController@search')->name('map.search');
Route::get('/map/upload', 'MapController@upload')->name('map.upload');
Route::get('/map/google', 'MapController@google')->name('map.google');
Route::post('/map/pitch', 'MapController@pitch')->name('map.pitch');
Route::post('/map/uploadImage', 'MapController@uploadImage')->name('map.upload');
Route::post('/map/record', 'MapController@record')->name('map.record');
Route::post('/map/load', 'MapController@load')->name('map.load');
Route::post('/map/real', 'MapController@real')->name('map.real');
Route::post('/map/remove', 'MapController@remove')->name('map.remove');
Route::post('/map/getmap', 'MapController@getmap')->name('map.getmap');
Route::post('/map/user_upload', 'MapController@user_upload')->name('map.user_upload');
Route::post('/map/download', 'MapController@download')->name('map.download');
Route::resource('map', 'MapController');