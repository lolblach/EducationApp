<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

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

Route::get('/', [PostController::class, 'mainpage'])->name('post.mainpage');
Route::get('/login', [UserController::class, 'loginpage'])->name('user.loginpage');
Route::get('/register', [UserController::class, 'registerpage'])->name('user.registerpage');
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
Route::get('/tags', [TagController::class, 'index'])->name('tag.index');
Route::get('/tag/delete/{id}', [TagController::class, 'delete'])->name('tag.delete');
Route::get('/post/create', [PostController::class, 'createpage'])->name('post.createpage');
Route::get('/post/view/{id}', [PostController::class, 'view'])->name('post.view');
Route::get('/tags/view/{id}', [TagController::class, 'view'])->name('tag.view');
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/user/changerole/{id}', [UserController::class, 'changerole'])->name('user.changerole');
Route::get('/test/view/{id}', [TestController::class, 'view'])->name('test.view');
Route::get('/test/del/{id}', [TestController::class, 'delete'])->name('test.delete');
Route::get('/post/delete/{id}', [PostController::class, 'delete'])->name('post.delete');

Route::post('/login/action', [UserController::class, 'login'])->name('user.login');
Route::post('/register/action', [UserController::class, 'register'])->name('user.register');
Route::post('/changepass/{name}', [UserController::class, 'changepass'])->name('user.changepass');
Route::post('/tag/create', [TagController::class, 'create'])->name('tag.create');
Route::post('/tag/create/action', [PostController::class, 'createaction'])->name('post.createaction');
Route::post('/image/download', [UserController::class, 'image'])->name('user.image');
Route::post('/test/add/{id}', [TestController::class, 'add'])->name('test.add');
Route::post('/test/confirm/{id}', [TestController::class, 'confirm'])->name('test.confirm');