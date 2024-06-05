<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Публичные маршруты
Route::post( '/register',                    'AuthController@register');
Route::post( '/login',                       'AuthController@login')->name('login');
Route::post( '/reset',                       'AuthController@resetPassword');

// Приватные маршруты
Route::middleware('auth:sanctum')->group(function () {
    Route::get(    '/users',                 'UserController@index');           //  Просмотр списка пользователей

    Route::get(    '/users/{user}',          'UserController@show');            //  Просмотр пользователя
    Route::put(    '/users/{user}',          'UserController@update');          //  Редактирование пользователя
    Route::delete( '/users/{user}',          'UserController@delete');          //  Удаление пользователя в корзину

    Route::get(    '/basket',                'UserController@showBasket');      //  Просмотр списка пользователей в корзине
    Route::post(   '/basket/{user}/restore', 'UserController@restore');         //  Восстановление пользователя из корзины
    Route::delete( '/basket/{user}',         'UserController@destroy');         //  Полное удаление пользователя из БД

    // Групповые операции
    Route::delete( '/users',                 'UserController@groupDelete');     //  Групповое удаление пользователей в корзину
    Route::delete( '/basket',                'UserController@groupDestroy');    //  Групповое удаление пользователей из БД
    Route::post(   '/basket/restore',        'UserController@groupRestore');    //  Групповое восстановление пользователей из корзины
});