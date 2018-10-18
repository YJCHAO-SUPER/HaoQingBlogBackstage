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
//Route::get('/system','IndexController@system');
Route::get('/insert','IndexController@insert');
Route::get('/showUpdate','IndexController@showUpdate');
Route::get('/delete','IndexController@delete');
Route::get('/captcha2', 'UserController@captcha');

Route::post('/getRegister','UserController@getRegister');
Route::post('/getLogin','UserController@getLogin');
Route::post('/insertArticle','IndexController@insertArticle');
Route::post('/updateArticle','IndexController@updateArticle');

Route::get('/sendMsg','UserController@sendMsg');
Route::get('/alisms','UserController@alisms');

Route::get('/permissions','PermissionController@permissions');
Route::get('/roles','RoleController@roles');
Route::get('/administrators','UserController@administrators');
Route::get('/createRole','PermissionController@createRole');
Route::get('/deleteRole','PermissionController@deleteRole');
Route::get('/createManage','RoleController@createManage');
Route::get('/showUpdateRole','PermissionController@showUpdateRole');
Route::get('/deleteManage','RoleController@deleteManage');
Route::get('/showUpdateManage','RoleController@showUpdateManage');

Route::post('/updateManage','RoleController@updateManage');
Route::post('/updateRole','PermissionController@updateRole');
Route::post('/insertRole','PermissionController@InsertRole');
Route::post('/insertManage','RoleController@InsertManage');


