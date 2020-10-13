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
Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->middleware('verified');

Route::group(['middleware' => ['auth', 'acl'], 'is' => 'user'], function () {
    Route::get('/reservations','ReservationController@index')->name('reservations.index')->middleware('verified');
});

Route::group(['middleware' => ['auth', 'acl'], 'is' => 'admin'], function () {
    Route::resource('tickets', 'TicketController');
});
