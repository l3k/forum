<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::put('/{user}/update', 'UserController@update');

    Route::post('/post/new', 'PostController@create');
    Route::get('/{user}/posts', 'PostController@listPosts');
    Route::delete('/post/{post}', 'PostController@delete');
    Route::put('/post/edit/{post}', 'PostController@update');
    
    
    Route::post('/comment/new', 'CommentController@create');
    Route::delete('/comment/{comment}', 'CommentController@delete');
    Route::put('/comment/edit/{post}', 'CommentController@update');
    // Route::get('user', 'UserController@getAuthenticatedUser');
    // Route::get('closed', 'DataController@closed');
});

// Route::get('/teste', function () {
//     dd("teste");
// });
Route::get('/posts', 'PostController@listAll');
