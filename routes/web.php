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

Auth::routes(['verify' => true]);

Route::middleware(['verified'])->group(function () {
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('/user', 'UserController');
    Route::resource('/role', 'RoleController');
    Route::resource('/code', 'CodeController');
});
