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
})->name('index');
Auth::routes();

//home
Route::get('/home', 'HomeController@index')->name('home');
Route::get('search', 'OtherController@search')->name('search');
Route::get('/profile', 'OtherController@showProfile')->name('profile');
Route::resource('workers', 'WorkerController', ['only' => ['index', 'create', 'store']]);
Route::get('workers/edit', 'WorkerController@edit')->name('workers.edit');
Route::post('workers/edit', 'WorkerController@update')->name('workers.update');
Route::get('workers/add', 'WorkerController@showAddServiceForm')->name('workers.addForm');
Route::post('workers/add', 'WorkerController@addNewService')->name('workers.addService');
Route::resource('transactions', 'TransactionController');

Route::resource('categories', 'CategoryController');
Route::resource('customer', 'CustomerController');
Route::group(['prefix' => 'api'], function () {
    Route::resource('worker', 'WorkerAPIController');
    Route::resource('transaction', 'TransactionAPIController');
    Route::resource('category', 'CategoryAPIController');
    Route::get('token/{token}', 'Auth\LoginController@getUserInfoFromToken');
});