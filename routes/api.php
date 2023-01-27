<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    /** @uses App\Http\Actions\ActionWithResourceResponse\ResourceAction */
    Route::get('/user/{with_group?}', 'App\Http\Actions\ActionWithResourceResponse\ResourceAction')
        ->name('user-info')
    ;
});

