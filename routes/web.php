<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['prefix' => 'database', 'as' => 'database.'], function() {
    Route::get('/create', 'App\Http\Controllers\AccountDatabaseController@create_check')->name('create_check');
    Route::get('/regist_tweet', 'App\Http\Controllers\AccountDatabaseController@regist_tweet')->name('regist_tweet');
    Route::get('/delete_tweet', 'App\Http\Controllers\AccountDatabaseController@delete_tweet')->name('delete_tweet');
    Route::get('/send_message', 'App\Http\Controllers\AccountDatabaseController@send_message')->name('send_message');
    Route::get('/send_friend_request', 'App\Http\Controllers\AccountDatabaseController@send_friend_request')->name('send_friend_request');
    Route::get('/approval_friend', 'App\Http\Controllers\AccountDatabaseController@approval_friend')->name('approval_friend');
    Route::get('/delete_friend', 'App\Http\Controllers\AccountDatabaseController@delete_friend')->name('delete_friend');
    Route::get('/delete_request', 'App\Http\Controllers\AccountDatabaseController@delete_request')->name('delete_request');
    Route::get('/search_account', 'App\Http\Controllers\AccountDatabaseController@search_account')->name('search_account');
    Route::get('/update_status', 'App\Http\Controllers\AccountDatabaseController@update_status')->name('update_status');
    Route::get('/update_password', 'App\Http\Controllers\AccountDatabaseController@update_password')->name('update_password');
    Route::get('/delete_account', 'App\Http\Controllers\AccountDatabaseController@delete_account')->name('delete_account');
    Route::get('/login', 'App\Http\Controllers\AccountDatabaseController@login_check')->name('login_check');
    Route::get('/logout', 'App\Http\Controllers\AccountDatabaseController@logout')->name('logout');

    Route::post('/create', 'App\Http\Controllers\AccountDatabaseController@create_check')->name('create_check');
    Route::post('/regist_tweet', 'App\Http\Controllers\AccountDatabaseController@regist_tweet')->name('regist_tweet');
    Route::post('/delete_tweet', 'App\Http\Controllers\AccountDatabaseController@delete_tweet')->name('delete_tweet');
    Route::post('/send_message', 'App\Http\Controllers\AccountDatabaseController@send_message')->name('send_message');
    Route::post('/clear_message', 'App\Http\Controllers\AccountDatabaseController@clear_message')->name('clear_message');
    Route::post('/chat_open_check', 'App\Http\Controllers\AccountDatabaseController@chat_open_check')->name('chat_open_check');
    Route::post('/get_message_total', 'App\Http\Controllers\AccountDatabaseController@get_message_total')->name('get_message_total');
    Route::post('/get_message_detail_1', 'App\Http\Controllers\AccountDatabaseController@get_message_detail_1')->name('get_message_detail_1');
    Route::post('/get_message_detail_2', 'App\Http\Controllers\AccountDatabaseController@get_message_detail_2')->name('get_message_detail_2');
    Route::post('/get_message', 'App\Http\Controllers\AccountDatabaseController@get_message')->name('get_message');
    Route::post('/get_tweet', 'App\Http\Controllers\AccountDatabaseController@get_tweet')->name('get_tweet');
    Route::post('/get_request', 'App\Http\Controllers\AccountDatabaseController@get_request')->name('get_request');
    Route::post('/send_friend_request', 'App\Http\Controllers\AccountDatabaseController@send_friend_request')->name('send_friend_request');
    Route::post('/approval_friend', 'App\Http\Controllers\AccountDatabaseController@approval_friend')->name('approval_friend');
    Route::post('/delete_friend', 'App\Http\Controllers\AccountDatabaseController@delete_friend')->name('delete_friend');
    Route::post('/delete_request', 'App\Http\Controllers\AccountDatabaseController@delete_request')->name('delete_request');
    Route::post('/search_account', 'App\Http\Controllers\AccountDatabaseController@search_account')->name('search_account');
    Route::post('/update_status', 'App\Http\Controllers\AccountDatabaseController@update_status')->name('update_status');
    Route::post('/update_password', 'App\Http\Controllers\AccountDatabaseController@update_password')->name('update_password');
    Route::post('/delete_account', 'App\Http\Controllers\AccountDatabaseController@delete_account')->name('delete_account');
    Route::post('/login', 'App\Http\Controllers\AccountDatabaseController@login_check')->name('login_check');
    Route::post('/logout', 'App\Http\Controllers\AccountDatabaseController@logout')->name('logout');
});
Route::group(['prefix' => 'account', 'as' => 'account.'], function() {
    Route::get('/', 'App\Http\Controllers\AccountController@index')->name('index');
    Route::get('/create', 'App\Http\Controllers\AccountController@create')->name('create');
    Route::get('/login', 'App\Http\Controllers\AccountController@login')->name('login');

    Route::post('/', 'App\Http\Controllers\AccountController@index')->name('index');
    Route::post('/create', 'App\Http\Controllers\AccountController@create')->name('create');
    Route::post('/login', 'App\Http\Controllers\AccountController@login')->name('login');
});