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

// Public routes
Route::get('/', 'PageController@index')->name('main');
Route::get('/category/{id}', 'PageController@category')->name('category');
Route::get('/posts/{id}', 'PostController@show')->name('show.post');
Route::post('/login', 'UserController@login')->name('login');
Route::post('/register', 'UserController@register')->name('register');

// Auth routes
Route::post('/exit', 'UserController@exit')->middleware('auth')->name('exit');
Route::group([
    'middleware' => ['auth', 'role:editor', 'role:admin'],
    'as'         => 'user.'
],function () {
    Route::get('/posts-manager', 'PostController@index')->name('index.posts');
    Route::get('/post/new', 'PostController@create')->name('create.post');
    Route::post('/post/new', 'PostController@store')->name('store.post');
    Route::get('/post/edit/{id}', 'PostController@edit')->name('edit.post');
    Route::put('/post/update/{id}', 'PostController@update')->name('update.post');
    Route::post('/post/delete/{id}', 'PostController@destroy')->name('destroy.post');
    Route::post('/post/publish/{id}', 'PostController@publish')->name('status.post');
});

// Admin routes
Route::group([
    'middleware' => ['auth', 'role:admin'],
    'prefix'     => 'admin',
    'as'         => 'admin.'
],function () {
    Route::get('/', 'AdminController@index')->name('index');
    Route::get('/users', 'AdminController@users')->name('users');
    Route::post('/user/delete/{id}', 'AdminController@deleteUsers')->name('delete.user');
    Route::get('/posts', 'AdminController@posts')->name('posts');
    Route::post('/post/delete/{id}', 'AdminController@deletePost')->name('delete.post');
    Route::post('/post/status/{id}', 'AdminController@statusPost')->name('status.post');
    Route::get('/categories', 'AdminController@categories')->name('categories');
    Route::post('/category/delete/{id}', 'AdminController@deleteCategory')->name('delete.category');
    Route::get('/tags', 'AdminController@tags')->name('tags');
    Route::post('/tag/delete/{id}', 'AdminController@deleteTag')->name('delete.tag');
    Route::post('/user/role/{id}', 'AdminController@roleUser')->name('role.user');
    Route::post('/user/delete-role/{id}', 'AdminController@deleteRoleUser')->name('delete.role.user');
});
