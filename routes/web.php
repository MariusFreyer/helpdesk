<?php

use App\Http\Controllers\TicketController;

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

Route::get('/home', 'HomeController@index')->name('home');

/**
 * TICKETS
 */

 Route::get('/', 'TicketController@create')->name('create_ticket');
 Route::post('/tickets', 'TicketController@store')->name('store_ticket');
 Route::patch('/tickets/{ticket}', 'TicketController@update')->name('update_ticket');
 Route::get('/tickets', 'TicketController@index')->name('index_ticket');
 Route::get('/tickets/{ticket}', 'TicketController@show')->name('show_ticket');
 Route::get('/tickets/{ticket}/edit', 'TicketController@edit')->name('edit_ticket');
 Route::post('/tickets/{ticket}/comments', 'CommentController@store')->name('store_comment');
 Route::get('/tickets/{ticket}/assign/{user_id}', 'TicketController@assign')->name('assign_ticket');
 Route::get('/tickets/{ticket}/release', 'TicketController@release')->name('release_ticket');
