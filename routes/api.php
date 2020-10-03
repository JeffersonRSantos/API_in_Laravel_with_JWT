<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('auth/login', 'Api\ApiController@login')->name('auth.login');

Route::group(['middleware' => ['apiJwt']], function () {
    Route::get('/produtos', 'Dashboard\PainelController@produtos')->name('dashboard.produtos');
});

Route::get('/access_token', 'Dashboard\PainelController@access')->name('dashboard.access');