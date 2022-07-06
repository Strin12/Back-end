<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\PostsController;
use App\Http\Middleware\JwtMiddleware;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('login', [UsuariosController::class, 'authenticate']);

Route::get('users/{id}', [UsuariosController::class, 'editar']);
Route::put('users/{id}', [UsuariosController::class, 'updated']);
Route::delete('users/{id}', [UsuariosController::class, 'delete']);
Route::post('upload', [UsuariosController::class, 'upload']);
Route::post('admin', [UsuariosController::class, 'registerAdmin']);
Route::post('users', [UsuariosController::class, 'register']);

Route::get('users', [UsuariosController::class, 'list']);

Route::get('posts/{id}', [PostsController::class, 'editar']);
Route::put('posts/{id}', [PostsController::class, 'updated']);
Route::put('activar/{id}', [PostsController::class, 'activar']);
Route::post('posts/upload', [PostsController::class, 'upload']);
Route::post('posts', [PostsController::class, 'create']);
Route::get('posts', [PostsController::class, 'listactivos']);
Route::get('postsInactivo', [PostsController::class, 'listaInactivos']);
Route::delete('posts/{id}', [PostsController::class, 'updated']);

Route::group(['middleware' => ['jwt.verify']], function () {


});
