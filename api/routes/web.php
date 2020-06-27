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

Route::get(
  '/',
  function () {
    echo 'API da Acquasana';
  }
);

Route::get(
  '/password',
  function () {
    $random = \Illuminate\Support\Str::random(12);
    echo 'Senha: ' . $random . '<br />';
    $hash = Hash::make($random);
    echo 'Hash: ' . $hash;
  }
);


Route::get('/home', 'HomeController@index')->name('home');

Route::get(
  '/oauth/verify/client-token',
  function (Request $request) {
  }
)->middleware('client.token');

Route::get(
  '/oauth/verify/user-token',
  function (Request $request) {
    return response(['client_id' => $request["oauth_client_id"]], 200);
  }
)->middleware('client');

Auth::routes();
