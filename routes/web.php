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

Route::get('pagseguro-transparente-cartao', ['as' => 'pag_card', 'uses' => 'PagSeguroController@cartao']);
Route::post('pagseguro-transparente-cartao', ['as' => 'pag_card_code', 'uses' => 'PagSeguroController@transacaoCartao']);
Route::post('pagseguro-boleto', ['as' => 'pag_boleto', 'uses' => 'PagSeguroController@boleto']);
Route::get('pagseguro-transparente', ['as' =>'pag_transparente', 'uses' => 'PagSeguroController@transparente']);
Route::post('pagseguro-transparente', ['as' =>'pag_transparente_code', 'uses' => 'PagSeguroController@getCode']);
Route::get('pagseguro', ['as' => 'pagseguro', 'uses' => 'PagSeguroController@pagseguro']);
Route::get('pagseguro-light', ['as' => 'paglight', 'uses' =>'PagSeguroController@lightbox']);
Route::post('pagseguro-light',
            ['as' => 'paglight.code', 'uses' => 'PagSeguroController@lightboxCode']);

Route::get('/', function () {
    return view('welcome');
});
