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

Auth::routes();

Route::get('/', function () {
    return redirect('/threads');
});

Route::get('/home', function () {
    return redirect()->route('profile' , auth()->user()->name);
})->name('home');

Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/replies' , 'RepliesController@store');
Route::get('/threads/{channel}/{thread}/replies' , 'RepliesController@index');
Route::patch('/replies/{reply}' , 'RepliesController@update');
Route::delete('/replies/{reply}' , 'RepliesController@destroy');


Route::post('/replies/{reply}/favorites' , 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites' , 'FavoritesController@destroy');


Route::get('/profiles/{user}' , 'ProfilesController@show')->name('profile');
