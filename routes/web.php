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

/** @uses App\Http\Actions\UrlParameters\UrlParametersAction */
Route::get('/url-parameters/{id}', 'App\Http\Actions\UrlParameters\UrlParametersAction')
    ->where('id', '[0-9]+')
    ->name('url-parameters')
;

/** @uses App\Http\Actions\ActionWithEvent\EventAction */
Route::get('/create-event/', 'App\Http\Actions\ActionWithEvent\EventAction')
     ->name('create-event')
;

/** @uses App\Http\Actions\ActionWithException\ExceptionAction */
Route::get('/exception/', 'App\Http\Actions\ActionWithException\ExceptionAction')
     ->name('make-exception')
;

/** @uses App\Http\Actions\ActionWithValidation\ValidationAction */
Route::get('/validation/', 'App\Http\Actions\ActionWithValidation\ValidationAction')
     ->name('make-validation-exception')
;

/** @uses App\Http\Actions\ActionWithNotification\NotificationAction */
Route::get('/notification/', 'App\Http\Actions\ActionWithNotification\NotificationAction')
     ->name('make-notification')
;
