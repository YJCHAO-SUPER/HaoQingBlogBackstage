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
    return view('welcome');
});

Route::get('/login','UserController@login');
Route::get('/register','UserController@register');
Route::get('/index','IndexController@index');
Route::get('/system','IndexController@system');
Route::get('/insert','IndexController@insert');
Route::get('/showUpdate','IndexController@showUpdate');
Route::get('/delete','IndexController@delete');
Route::get('/captcha2/{tmp}', 'UserController@captcha');

Route::post('/getRegister','UserController@getRegister');
Route::post('/getLogin','UserController@getLogin');
Route::post('/insertArticle','IndexController@insertArticle');
Route::post('/updateArticle','IndexController@updateArticle');

Route::get('/sendMsg','UserController@sendMsg');
Route::get('/alisms','UserController@alisms');



