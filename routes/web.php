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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['prefix' => 'panel', 'middleware' => 'role:admin' , 'namespace'=>'App\Http\Controllers'], function () {
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit');
    Route::post('users/{user}/edit', 'UserController@update')->name('users.update');
    Route::get('roles', 'RoleController@index')->name('roles.index');
    Route::post('roles', 'RoleController@store')->name('roles.store');
    Route::get('roles/{role}/edit', 'RoleController@edit')->name('roles.edit');
    Route::post('roles/{role}/edit', 'RoleController@update')->name('roles.update');
});

Route::group(['namespace'=>'App\Http\Controllers'], function () {
    Route::get('products', 'ProductsController@index')->name('products.index');
});
