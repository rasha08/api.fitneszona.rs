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

Route::get('api/articles/all', 'ArticlesController@all')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/top', 'ArticlesController@top')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/latest', 'ArticlesController@latest')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/category/{category}', 'ArticlesController@category')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/category/{category}/top', 'ArticlesController@categoryTopArticles')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/category/{category}/latest', 'ArticlesController@categoryLatestArticles')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/{id}', 'ArticlesController@article')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/{id}/catgory-and-tags', 'ArticlesController@getArticleCategoryAndTags')->middleware(['api', 'throttle:500,1']);
Route::get('api/articles/all/create-url-slugs', 'ArticlesController@createUrlSlugs')->middleware(['api', 'throttle:500,1']);
Route::post('api/articles/all/counter', 'ArticlesController@counter')->middleware(['api', 'throttle:500,1']);

Route::post('api/articles/{id}/', 'ArticlesController@action')->middleware('api');

Route::group(['middleware' => ['api']], function () {
    Route::resource('users', 'WebsiteUsersController');
});

Route::get('users', 'WebsiteUsersController@index')->middleware(['auth','api']);
Route::delete('users/{id}', 'WebsiteUsersController@destroy')->middleware(['auth','api']);
Route::post('users', 'WebsiteUsersController@store')->middleware('api');

Route::post('api/users/action/{id}/', 'WebsiteUsersController@action')->middleware('api');
Route::post('api/users/login', 'WebsiteUsersController@login')->middleware('api');
Route::post('api/users/reset-password', 'WebsiteUsersController@resetPassword')->middleware('api');
Route::post('api/users/{id}/{data}', 'WebsiteUsersController@getUserSpecificData')->middleware('api');


Route::group(['middleware' => ['api', 'auth']], function () {
    Route::resource('configuration', 'WebsiteConsfigurationController');
});
Route::get('api/configuration/{id}', 'WebsiteConsfigurationController@getConfiguration')->middleware(['api', 'throttle:500,1']);
Route::get('api/configuration/{id}/categories', 'WebsiteConsfigurationController@getActiveCategories')->middleware(['api', 'throttle:500,1']);

Route::post('test', 'TestController@action')->middleware(['auth','api']);
Route::get('test', 'TestController@index')->middleware(['auth','api']);