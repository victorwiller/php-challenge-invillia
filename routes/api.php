<?php

use Illuminate\Http\Request;

Route::post('/login', [
    'as'     => 'api.login',
    'uses'   => 'App\Http\Controllers\Api\Auth\LoginController@login'
]);

Route::post('/upload', [
    'as'    => 'upload.index',
    'uses'  => 'App\Http\Controllers\Api\UploadController@index'
]);

Route::get('/peoples', [
    'as'    => 'peoples.index',
    'uses'  => 'App\Http\Controllers\Api\PeoplesController@index'
]);

Route::get('/peoples/{people}', [
    'as'    => 'peoples.show',
    'uses'  => 'App\Http\Controllers\Api\PeoplesController@show'
]);

Route::get('/orders', [
    'as'    => 'orders.index',
    'uses'  => 'App\Http\Controllers\Api\OrdersController@index'
]);

Route::get('/orders/{order}', [
    'as'    => 'orders.show',
    'uses'  => 'App\Http\Controllers\Api\OrdersController@show'
]);