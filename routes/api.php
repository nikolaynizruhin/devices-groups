<?php


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

Route::apiResource('groups', 'GroupController');
Route::apiResource('devices', 'DeviceController');

// Connect device to a group
Route::post('devices/{device}/connect', 'DeviceGroupController@store');

// Disconnect device from a group
Route::delete('devices/{device}/disconnect', 'DeviceGroupController@destroy');
