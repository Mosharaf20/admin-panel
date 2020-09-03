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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/users', 'UserController@index')->name('users.index');
Route::get('/all-users', 'UserController@allUser')->name('all-user.index');
Route::post('/users', 'UserController@store')->name('users.store');
Route::delete('/users/{user}', 'UserController@destroy')->name('users.destroy');
Route::patch('/users/{user}', 'UserController@update')->name('users.update');
Route::post('users/search', 'UserController@search')->name('users.search');
Route::get('/users/notification/', 'UserController@notification')->name('users.notification');

Route::get('/profiles','ProfileController@index')->name('profiles.index');
Route::post('/profiles/image','ProfileController@profileImage')->name('profiles.image');
Route::post('/profiles/{user}','ProfileController@store')->name('profiles.store');

Route::post('/profiles','ProfileController@profile');

Route::post('/images','GalleryController@store');
Route::get('/images','GalleryController@index');
Route::delete('/images/{gallery}','GalleryController@destroy');
