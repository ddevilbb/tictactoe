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

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web', 'player_auth']], function () {
    Route::get('/new_game', 'GameController@newGame')->name('new_game');
    Route::get('/game/{id}', 'GameController@showGame')->name('show_game');
    Route::get('/select-parameters', 'GameController@selectParameters')->name('select_parameters');
    Route::post('/save-parameters', 'GameController@saveParameters')->name('save_parameters');

    Route::get('/history', 'PlayerController@getHistory')->name('history');

    Route::post('/make_turn', 'TurnController@makeTurn')->name('make_turn');
});

