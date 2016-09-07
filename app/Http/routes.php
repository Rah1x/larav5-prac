<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


/* Admin Routes */
Route::group([
'prefix' => 'back_adm',
'namespace' => 'back_adm',
'middleware' => ['adminBasicAuth', 'web'],
],
function(){
    Route::get('/', 'home@index');
    Route::get('home', ['as'=>'home', 'uses'=>'home@index']);
    Route::get('logout', ['as'=>'logout', 'uses'=>'login@logout']);
    Route::match(['GET', 'POST'], 'login', ['as'=>'login', 'uses'=>'login@index']);
    Route::match(['GET', 'POST'], 'recover-access', ['as'=>'recover', 'uses'=>'recover_password@index']);
    Route::get('my-settings/opp', ['as'=>'my-settings/opp', 'uses'=>'home@index']);
});

Route::get('secure-captcha', ['as'=>'secure-captcha', 'uses'=>'sec_captcha@index']);
