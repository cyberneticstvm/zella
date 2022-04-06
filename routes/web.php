<?php

use Illuminate\Support\Facades\Route;

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
    return view('login');
});

Route::post('/', 'App\Http\Controllers\UserController@login')->name('user.login');

Route::group(['middleware' => ['auth', 'disable_back_btn']], function(){

    Route::get('/logout/', 'App\Http\Controllers\UserController@logout');
    Route::get('/dash/', function () {
        return view('dash');
    })->name('dash');

    // user //
    Route::get('/user/', 'App\Http\Controllers\UserController@index')->name('user.index');
    Route::get('/user/create/', function () {
        return view('user.create');
    });
    Route::post('/user/create/', 'App\Http\Controllers\UserController@store')->name('user.create');
    Route::get('/user/{id}/edit/', 'App\Http\Controllers\UserController@edit')->name('user.edit');
    Route::put('/user/{id}/edit/', 'App\Http\Controllers\UserController@update')->name('user.update');
    Route::delete('/user/{id}/delete/', 'App\Http\Controllers\UserController@destroy')->name('user.delete');
    // end user //
});
