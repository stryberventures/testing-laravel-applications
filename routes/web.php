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

Route::get('/some-endpoint/{id}', 'App\Http\Actions\Some\SomeAction')
    ->where('id', '[0-9]+')
    ->name('some-endpoint')
;

Route::get('/create-event/', 'App\Http\Actions\ActionWithEvent\EventAction')
     ->name('create-event')
;
