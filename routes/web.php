<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['api', 'auth']], function () {
    Route::resource('articles', 'ArticlesController');
});

Route::get('api/articles/all', 'ArticlesController@all')->middleware('api');
Route::get('api/articles/top', 'ArticlesController@top')->middleware('api');
Route::get('api/articles/latest', 'ArticlesController@latest')->middleware('api');
Route::get('api/articles/category/{category}', 'ArticlesController@category')->middleware('api');
Route::get('api/articles/category/{category}/top', 'ArticlesController@categoryTopArticles')->middleware('api');
Route::get('api/articles/category/{category}/latest', 'ArticlesController@categoryLatestArticles')->middleware('api');
Route::get('api/articles/{id}', 'ArticlesController@article')->middleware('api');

Route::post('api/articles/{id}/', 'ArticlesController@action')->middleware('api');

Route::group(['middleware' => ['api']], function () {
    Route::resource('users', 'WebsiteUsersController');
});

Route::post('api/users/action/{id}/', 'WebsiteUsersController@action')->middleware('api');
Route::post('api/users/login', 'WebsiteUsersController@login')->middleware('api');
Route::post('api/users/reset-password', 'WebsiteUsersController@resetPassword')->middleware('api');

Route::group(['middleware' => ['api', 'auth']], function () {
    Route::resource('configuration', 'WebsiteConsfigurationController');
});
Route::get('api/configuration/{id}', 'WebsiteConsfigurationController@getConfiguration')->middleware('api');