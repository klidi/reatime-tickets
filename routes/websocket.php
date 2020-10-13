<?php


use Illuminate\Http\Request;
use SwooleTW\Http\Websocket\Facades\Websocket;

/*
|--------------------------------------------------------------------------
| Websocket Routes
|--------------------------------------------------------------------------
|
| Here is where you can register websocket events for your application.
|
*/

Websocket::on('connect', function ($websocket, Request $request) {
    $websocket->emit('connected', 'Welcome');
})->middleware(\SwooleTW\Http\Websocket\Middleware\Authenticate::class);

Websocket::on('disconnect', function ($websocket) {
    // called while socket on disconnect
});

Websocket::on('makeReservation', 'App\Http\Controllers\ReservationController@store')->middleware(\SwooleTW\Http\Websocket\Middleware\Authenticate::class);
