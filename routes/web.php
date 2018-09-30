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

Auth::routes();

Route::get('/home', 'PostsController@index');
Route::resource('users', 'UserController');
Route::get('users/{user}/delete', 'UserController@destroyForm');
Route::get('users/{user}/messages', 'UserController@getMessages');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('/messages/create/{post}/{receiver}/{sender}', 'MessagesController@create');
Route::resource('posts', 'PostsController');
Route::resource('messages', 'MessagesController', ['only' => ['create', 'store', 'show', 'edit', 'destroy']]);