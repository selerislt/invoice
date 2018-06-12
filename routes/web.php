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
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Clients
Route::get('/clients', 'ClientController@index')->name('clients');
Route::get('/clients/new', 'ClientController@add')->name('addClient');
Route::get('/clients/{client_id}', 'ClientController@view')->name('viewClient');
Route::get('/clients/{client_id}/edit', 'ClientController@edit')->name('editClient');

Route::post('/clients/new', 'ClientController@post')->name('postClient');
Route::post('/clients/{client_id}/destroy', 'ClientController@destroy')->name('destroyClient');
Route::post('/clients/{client_id}', 'ClientController@update')->name('updateClient');

//Services
Route::get('/clients/service/new', 'ServiceController@add')->name('addService');
Route::get('/clients/service/{id}', 'ServiceController@view')->name('viewService');
Route::get('/clients/service/{id}/edit', 'ServiceController@edit')->name('editService');
Route::get('/clients/all/services', 'ServiceController@all')->name('allServices');

Route::post('/clients/service/new', 'ServiceController@post')->name('postService');
Route::post('/clients/service/{id}/update', 'ServiceController@update')->name('updateService');
Route::post('/clients/service/{id}/attachmnent/destroy', 'ServiceController@destroyAttachment')->name('destroyAttachment');
Route::post('/clients/service/{id}/destroy', 'ServiceController@destroy')->name('destroyService');

Route::post('/generate/pdf/all', 'ServiceController@generatePDFall')->name('generatePDFall');
