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
 * Supporter
 */
Route::middleware(['role:supporter'])->group(function () {
    Route::get('/tickets', 'TicketController@index')->name('index_ticket');
    Route::get('/tickets/{ticket}/assign/{user_id}', 'TicketController@assign')->name('assign_ticket');
    Route::get('/tickets/{ticket}/release', 'TicketController@release')->name('release_ticket');
    Route::get('/tickets/{ticket}/close', 'TicketController@close')->name('close_ticket');
    Route::get('/tickets/{ticket}/finish', 'TicketController@finish')->name('finish_ticket');
    Route::get('/tickets/{ticket}/reopen', 'TicketController@reopen')->name('reopen_ticket');
    Route::get('/tickets/{ticket}/reset', 'TicketController@reset')->name('reset_ticket');
});

/**
 * Admin
 */
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/users', 'AdminController@user_index')->name('index_user');
});

 Route::get('/', 'TicketController@create')->name('create_ticket');
 Route::post('/tickets', 'TicketController@store')->name('store_ticket');
 Route::patch('/tickets/{ticket}', 'TicketController@update')->name('update_ticket');
 Route::get('/tickets/{ticket}', 'TicketController@show')->name('show_ticket');
 Route::get('/tickets/{ticket}/edit', 'TicketController@edit')->name('edit_ticket');
 Route::post('/tickets/{ticket}/comments', 'CommentController@store')->name('store_comment');
