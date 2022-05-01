<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CatPostController;

Route::group(['namespace' => 'Web', 'as' => 'web.'], function () {

    /** Página Inicial */
    //Route::get('/', 'WebController@home')->name('home');
    Route::get('/', [WebController::class, 'home'])->name('home');

    /** Página Destaque */
    Route::get('/destaque', 'WebController@spotlight')->name('spotlight');
    
    /** Página Inicial */
    Route::match(['post', 'get'], '/filtro', 'WebController@filter')->name('filter');
   
    /** Página Inicial */
    Route::get('/atendimento', 'WebController@atendimento')->name('atendimento');
    Route::get('/sendEmail', 'WebController@sendEmail')->name('sendEmail');
    Route::get('/sendNewsletter', 'WebController@sendNewsletter')->name('sendNewsletter');

    /** Página de Locação */
    Route::get('/quero-alugar', 'WebController@locacao')->name('locacao');

    /** Página de Locaçãp - Específica de um imóvel */
    Route::get('/quero-alugar/{slug}', 'WebController@rentProperty')->name('rentProperty');

    /** Página de Compra */
    Route::get('/quero-comprar', 'WebController@venda')->name('venda');

    /** Página de Compra - Específica de um imóvel */
    Route::get('/quero-comprar/{slug}', 'WebController@buyProperty')->name('buyProperty');  
    
    /** Página de Experiências */
    Route::get('/experiencias', 'WebController@experience')->name('experience');

    /** Página de Experiências - Específica de uma categoria */
    Route::get('/experiencias/{slug}', 'WebController@experienceCategory')->name('experienceCategory');

    /****************************** Blog ***********************************************/
    Route::get('/blog/artigo/{slug}', 'WebController@artigo')->name('blog.artigo');
    Route::get('/blog/categoria/{slug}', 'WebController@categoria')->name('blog.categoria');
    Route::get('/blog/artigos', 'WebController@artigos')->name('blog.artigos');

    /****************************** Notícias *******************************************/
    Route::get('/noticia/{slug}', 'WebController@noticia')->name('noticia');
    Route::get('/noticias', 'WebController@noticias')->name('noticias');

    /****************************** Páginas *******************************************/
    Route::get('/pagina/{slug}', 'WebController@pagina')->name('pagina');
    Route::get('/paginas', 'WebController@paginas')->name('paginas');

    /** Pesquisa */
    Route::match(['post', 'get'], '/pesquisa', 'WebController@pesquisa')->name('pesquisa');

    /** FEED */
    //Route::get('feed', 'RssFeedController@feed');
    Route::get('feed', [RssFeedController::class, 'feed'])->name('feed');
    

});

Route::prefix('admin')->middleware('auth')->group( function(){

    /********************* Categorias para Posts *******************************/
    Route::get('categorias/delete', [CatPostController::class, 'delete'])->name('categorias.delete');
    Route::delete('categorias/deleteon', [CatPostController::class, 'deleteon'])->name('categorias.deleteon');
    Route::put('categorias/posts/{id}', [CatPostController::class, 'update'])->name('categorias.update');
    Route::get('categorias/{id}/edit', [CatPostController::class, 'edit'])->name('categorias.edit');
    Route::match(['post', 'get'],'posts/categorias/create/{catpai}', [CatPostController::class, 'create'])->name('categorias.create');
    Route::post('posts/categorias/store', [CatPostController::class, 'store'])->name('categorias.store');
    Route::get('posts/categorias', [CatPostController::class, 'index'])->name('categorias.index');

    /********************** Blog ************************************************/
    Route::get('posts/set-status', [PostController::class, 'postSetStatus'])->name('posts.postSetStatus');
    Route::get('posts/delete', [PostController::class, 'delete'])->name('posts.delete');
    Route::delete('posts/deleteon', [PostController::class, 'deleteon'])->name('posts.deleteon');
    Route::post('posts/image-set-cover', [PostController::class, 'imageSetCover'])->name('posts.imageSetCover');
    Route::delete('posts/image-remove', [PostController::class, 'imageRemove'])->name('posts.imageRemove');
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::post('posts/categoriaList', [PostController::class, 'categoriaList'])->name('posts.categoriaList');
    Route::get('posts/artigos', [PostController::class, 'index'])->name('posts.artigos');
    Route::get('posts/noticias', [PostController::class, 'index'])->name('posts.noticias');
    Route::get('posts/paginas', [PostController::class, 'index'])->name('posts.paginas');

    /*********************** Email **********************************************/
    Route::get('email/suporte', [EmailController::class, 'suporte'])->name('email.suporte');
    Route::match(['post', 'get'], 'email/send', [EmailController::class, 'send'])->name('email.send');
    Route::post('email/sendEmail', [EmailController::class, 'sendEmail'])->name('email.sendEmail');
    Route::match(['post', 'get'], 'email/success', [EmailController::class, 'success'])->name('email.success');

    /*********************** Usuários *******************************************/
    Route::match(['get', 'post'], 'usuarios/pesquisa', [UserController::class, 'search'])->name('users.search');
    Route::match(['post', 'get'], 'usuarios/fetchCity', [UserController::class, 'fetchCity'])->name('users.fetchCity');
    Route::delete('usuarios/deleteon', [UserController::class, 'deleteon'])->name('users.deleteon');
    Route::get('usuarios/set-status', [UserController::class, 'userSetStatus'])->name('users.userSetStatus');
    Route::get('usuarios/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('usuarios/time', [UserController::class, 'team'])->name('users.team');
    Route::get('usuarios/view/{id}', [UserController::class, 'show'])->name('users.view');
    Route::put('usuarios/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('usuarios/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('users.create');
    Route::post('usuarios/store', [UserController::class, 'store'])->name('users.store');
    Route::get('usuarios', [UserController::class, 'index'])->name('users.index');

    Route::get('/', [AdminController::class, 'home'])->name('home');
});


Auth::routes();
