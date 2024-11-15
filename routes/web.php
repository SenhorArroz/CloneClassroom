<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SalasController;
use App\Http\Controllers\MenuSalaController;

Route::get('/', [SiteController::class, 'index'])->name('site.home');

Route::get('/perfil/{userSlug}', [SiteController::class, 'perfil'])->name('site.perfil');
Route::get('/salasdeaula', [SiteController::class, 'salasdeaula'])->name('site.salasdeaula');

Route::get('/login', [SiteController::class, 'loginView'])->name('login.loginView');
Route::post('/auth', [loginController::class, 'auth'])->name('login.login');
Route::get('/registro', [SiteController::class, 'registrarView'])->name('login.registrarView');
Route::post('/registro', [UserController::class, 'create'])->name('login.registrar');
Route::get('/logout', [loginController::class, 'logout'])->name('login.logout');

Route::post('/salacreate', [SalasController::class, 'create'])->name('sala.create');
Route::get('/salaDelete/{id}', [SalasController::class, 'destroy'])->name('sala.delete');
Route::post('/salajoin', [SalasController::class, 'join'])->name('sala.join');
Route::get('/salasdeaula/{salaSlug}', [SiteController::class, 'acessarSala'])->name('sala.sala');
Route::get('/salaMural/{slug}', [SiteController::class, 'salaMural'])->name('sala.mural');
Route::get('/salaAtividades/{slug}', [SiteController::class, 'salaAtividades'])->name('sala.atividade');
Route::get('/salaIntegrantes/{slug}', [SiteController::class, 'salaIntegrantes'])->name('sala.integrantes');


Route::get('/salaMural/{slug}/post/{postName}/{id}', [SiteController::class, 'postView'])->name('mural.post');
Route::post('/salaPostar', [MenuSalaController::class, 'criarPost'])->name('sala.post');
Route::get('/salaDeletePost/{salaSlug}/{idPost}', [MenuSalaController::class, 'deletePost'])->name('mural.postDelete');
Route::post('/salaPostComment', [MenuSalaController::class, 'criarCommentPost'])->name('mural.postComment');

Route::post('/categoriaCriate', [MenuSalaController::class, 'criarCategoria'])->name('categoria.criar');
Route::post('/categoriaDelete', [MenuSalaController::class, 'deletarCategoria'])->name('categoria.delete');

Route::post('/atividadeCreate', [MenuSalaController::class, 'criarAtividade'])->name('atividade.criate');
Route::get('/atividadeDelete/{salaSlug}/{idAtividade}', [MenuSalaController::class, 'deletarAtividade'])->name('atividade.delete');
Route::get('/salaAtividades/{slug}/atividade/{atividadeTitulo}/{id}', [SiteController::class, 'acessarAtividade'])->name('atividade.atividade');
Route::post('/responderAtividade', [MenuSalaController::class, 'responderAtividade'])->name('atividade.responder');

Route::post('/perguntaCreate', [MenuSalaController::class, 'criarPergunta'])->name('pergunta.create');

Route::post('/perfilUpdate', [UserController::class, 'update'])->name('perfil.update');

Route::get('/trocarTema', [SiteController::class, 'trocarTema'])->name('tema.trocar');