<?php

use Illuminate\Support\Facades\Route;

Route::get( '/',             'App\Http\Controllers\UserController@login');
Route::get(  '/users',       'App\Http\Controllers\UserController@index');
Route::get(  '/histories',   'App\Http\Controllers\HistorieController@index');
