<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

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
})->name('login');

Route::post('/', 'App\Http\Controllers\UserController@login')->name('user.login');

Route::group(['middleware' => ['auth']], function(){

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

    // collection //
    Route::get('/collection/', 'App\Http\Controllers\CollectionController@index')->name('collection.index');
    Route::get('/collection/create/', function () {
        return view('collection.create');
    });
    Route::post('/collection/create/', 'App\Http\Controllers\CollectionController@store')->name('collection.create');
    Route::get('/collection/{id}/edit/', 'App\Http\Controllers\CollectionController@edit')->name('collection.edit');
    Route::put('/collection/{id}/edit/', 'App\Http\Controllers\CollectionController@update')->name('collection.update');
    Route::delete('/collection/{id}/delete/', 'App\Http\Controllers\CollectionController@destroy')->name('collection.delete');
    // end collection //

    // variant //
    Route::get('/variant/', 'App\Http\Controllers\VariantController@index')->name('variant.index');
    Route::get('/variant/create/', 'App\Http\Controllers\VariantController@create')->name('variant.create');
    Route::post('/variant/create/', 'App\Http\Controllers\VariantController@store')->name('variant.create');
    Route::get('/variant/{id}/edit/', 'App\Http\Controllers\VariantController@edit')->name('variant.edit');
    Route::put('/variant/{id}/edit/', 'App\Http\Controllers\VariantController@update')->name('variant.update');
    Route::delete('/variant/{id}/delete/', 'App\Http\Controllers\VariantController@destroy')->name('variant.delete');
    // end variant //

    // product //
    Route::get('/product/', 'App\Http\Controllers\ProductController@index')->name('product.index');
    Route::get('/product/create/', 'App\Http\Controllers\ProductController@create')->name('product.create');
    Route::post('/product/create/', 'App\Http\Controllers\ProductController@store')->name('product.create');
    Route::get('/product/{id}/edit/', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::put('/product/{id}/edit/', 'App\Http\Controllers\ProductController@update')->name('product.update');
    Route::delete('/product/{id}/delete/', 'App\Http\Controllers\ProductController@destroy')->name('product.delete');
    // end product //

    // suppler //
    Route::get('/supplier/', 'App\Http\Controllers\SupplierController@index')->name('supplier.index');
    Route::get('/supplier/create/', function () {
        return view('supplier.create');
    });
    Route::post('/supplier/create/', 'App\Http\Controllers\SupplierController@store')->name('supplier.create');
    Route::get('/supplier/{id}/edit/', 'App\Http\Controllers\SupplierController@edit')->name('supplier.edit');
    Route::put('/supplier/{id}/edit/', 'App\Http\Controllers\SupplierController@update')->name('supplier.update');
    Route::delete('/supplier/{id}/delete/', 'App\Http\Controllers\SupplierController@destroy')->name('supplier.delete');
    // end supplier //

    // purchase //
    Route::get('/purchase/', 'App\Http\Controllers\PurchaseController@index')->name('purchase.index');
    Route::get('/purchase/create/', 'App\Http\Controllers\PurchaseController@create')->name('purchase.create');
    Route::post('/purchase/create/', 'App\Http\Controllers\PurchaseController@store')->name('purchase.save');
    Route::get('/purchase/{id}/edit/', 'App\Http\Controllers\PurchaseController@edit')->name('purchase.edit');
    Route::put('/purchase/{id}/edit/', 'App\Http\Controllers\PurchaseController@update')->name('purchase.update');
    Route::delete('/purchase/{id}/delete/', 'App\Http\Controllers\PurchaseController@destroy')->name('purchase.delete');
    // end purchase //

    // sales //
    Route::get('/sales/', 'App\Http\Controllers\SalesController@index')->name('sales.index');
    Route::get('/sales/create/', 'App\Http\Controllers\SalesController@create')->name('sales.create');
    Route::post('/sales/create/', 'App\Http\Controllers\SalesController@store')->name('sales.save');
    Route::get('/sales/{id}/edit/', 'App\Http\Controllers\SalesController@edit')->name('sales.edit');
    Route::put('/sales/{id}/edit/', 'App\Http\Controllers\SalesController@update')->name('sales.update');
    Route::delete('/sales/{id}/delete/', 'App\Http\Controllers\SalesController@destroy')->name('sales.delete');
    // end sales //

    // helper //
    Route::get('/helper/product/', 'App\Http\Controllers\HelperController@getproducts');
    Route::get('/helper/product/{id}', 'App\Http\Controllers\HelperController@getproduct');
    // end helper //

    // pdf //
    Route::get('/sales-invoice/{id}/', [PDFController::class, 'salesinvoice']);
    // end pdf //
});
