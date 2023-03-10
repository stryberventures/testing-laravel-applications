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

/** @uses App\Http\Actions\ActionWithUrlParameters\UrlParametersAction */
Route::get('/url-parameters/{id}', 'App\Http\Actions\ActionWithUrlParameters\UrlParametersAction')
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

/** @uses \App\Http\Actions\ActionWithFile\UploadFile\UploadFileAction */
Route::post('/upload-file/', 'App\Http\Actions\ActionWithFile\UploadFile\UploadFileAction')
     ->name('upload-file')
;

/** @uses App\Http\Actions\ActionWithFile\DownloadFile\DownloadFileAction */
Route::get('/download-file/', 'App\Http\Actions\ActionWithFile\DownloadFile\DownloadFileAction')
     ->name('download-file')
;

/** @uses App\Http\Actions\ActionWithTime\TimeAction */
Route::get('/time-machine/', 'App\Http\Actions\ActionWithTime\TimeAction')
     ->name('time-machine')
;

/** @uses App\Http\Actions\ActionWithHttpRequest\HttpRequestAction */
Route::get('/http/', 'App\Http\Actions\ActionWithHttpRequest\HttpRequestAction')
     ->name('http')
;
