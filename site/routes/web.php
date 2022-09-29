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

Route::redirect('/', '/sobre-nos', 301);

Route::get('/sobre-nos', function () {
    return view('sobre-nos');
})->name('sobre-nos');

Route::redirect('/servicos', '/servicos/condominio', 301);
Route::redirect('/servicos/empresa', '/servicos/condominio', 301);

Route::get('/servicos/residencia', function () {
    return view('servicos-residencia');
})->name('servicos-residencia');

Route::get('/servicos/condominio', function () {
    return view('servicos-condominio');
})->name('servicos-condominios');

Route::get('/vantagens', function () {
    return view('vantagens');
})->name('vantagens');

Route::get('/informacoes/estacao-tratamento', function () {
    return view('estacao-tratamento');
})->name('estacao-tratamento');

Route::get('/informacoes/legislacao', function () {
    return view('legislacao');
})->name('legislacao');

Route::get('/informacoes/perguntas-frequentes', function () {
    return view('perguntas-frequentes');
})->name('perguntas-frequentes');

Route::get('/contato', function () {
    return view('contato');
})->name('contato');

Route::post('/contato', 'ContatoController@send');

Route::redirect('/clientes', '/area-restrita', 301);

Route::get('/area-restrita', 'AreaRestritaController@index')->name('area-restrita');

Auth::routes();

Route::get('/sair', 'Auth\LoginController@logout')->name('sair');
