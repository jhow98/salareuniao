<?php

/*
  |--------------------------------------------------------------------------
  | Rotas da aplicação
  |--------------------------------------------------------------------------
  |
  | o middleware garante que apenas usuários autenticados terão acesso às rotas do grurpo.
  |
 */



Route::middleware(['auth'])->group(function () {//garante que as rotas serão acessadas apenas enquanto o usuário estiver logado.
    Route::post('event/getDay', 'EventsController@getDay');
    Route::post('event/getModalNewScheduling', 'EventsController@getModalNewScheduling');
    Route::post('event/getModalReserva', 'EventsController@getModalReserva');
    Route::post('event/store', 'EventsController@store');
    Route::post('event/delete', 'EventsController@delete');
    Route::post('event/edit', 'EventsController@edit');
    Route::get('/', 'HomeController@index');
});

Auth::routes();
Route::get('/home', 'HomeController@home')->name('home');
