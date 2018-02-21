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



Route::group(['prefix' =>'dashboard'], function () {
    Route::post('register',[
        'uses' => 'AuthController@register'
    ]);
    Route::post('login', [
        'uses' => 'AuthController@login'
    ]);

    Route::post('recover', [
        'uses' => 'AuthController@recover'
    ]);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('check-token', [
            'uses' => 'AuthController@check_token'
        ]);

        Route::get('user', [
            'uses' => 'AuthController@getUser'
        ]);

        Route::get('logout', [
            'uses' => 'AuthController@logout'
        ]);

        Route::get('post', [
            'uses' => 'Dashboard\DashboardController@index'
        ]);

        Route::post('/ip', [
            'uses' => 'AuthController@getIp'
        ]);
        Route::group(['prefix' =>'categories'], function () {

           Route::get('/', [
               'uses' => 'Dashboard\CategoryController@getCategories'
           ]);
           Route::post('/', [
                'uses' => 'Dashboard\CategoryController@createCategories'
           ]);
           Route::put('{id}', [
                'uses' => 'Dashboard\CategoryController@updateCategories'
           ]);
            Route::delete('{id}', [
                'uses' => 'Dashboard\CategoryController@deleteCategories'
            ]);

        });

        Route::group(['prefix' => 'posts'], function () {

            Route::get('/', [
                'uses' => 'Dashboard\PostController@getAllPost'
            ]);
            Route::get('{id}/categories', [
                'uses' => 'Dashboard\PostController@getCate'
            ]);
            Route::post('/',[
                'uses' => 'Dashboard\PostController@createPost'
            ]);
            Route::put('{id}', [
                'uses' => 'Dashboard\PostController@updatePost'
            ]);
            Route::delete('{id}', [
                'uses' => 'Dashboard\PostController@deletePost'
            ]);
        });

        Route::group(['prefix' => 'tags'],function() {
            Route::get('/', [
                'uses' => 'Dashboard\TagController@getTag'
            ]);
            Route::post('/', [
                'uses' => 'Dashboard\TagController@createTag'
            ]);
            Route::put('{id}', [
                'uses' => 'Dashboard\TagController@updateTag'
            ]);
            Route::delete('{id}', [
                'uses' => 'Dashboard\TagController@deleteTag'
            ]);
        });

        Route::group(['prefix' => 'users'], function() {
            Route::get('/', [
                'uses' => 'Dashboard\UserController@getAllUser'
            ]);
            Route::get('{id}/password', [
                'uses' => 'Dashboard\UserController@getPassword'
            ]);
        });
    });
});

Route::group(['prefix' => 'homepages'], function () {

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [
            'uses' => 'HomePage\CategoryController@index'
        ]);

    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [
            'uses' => 'HomePage\PostController@index'
        ]);
        Route::get('{id}/detail', [
            'uses' => 'HomePage\PostController@show'
        ]);
        Route::post('{id}/counter',[
            'uses' => 'HomePage\PostController@counter'
        ]);
        Route::get('/popular', [
            'uses' => 'HomePage\PostController@popular'
        ]);
        Route::get('/recent',[
            'uses' => 'HomePage\PostController@recent'
        ]);
        Route::get('/{keyword}/search', [
            'uses' => 'HomePage\PostController@search'
        ]);
//        Route::get('/{keyword}/tags', [
//            'uses' => 'PostController@postTag'
//        ]);
    });

    Route::group(['prefix' => 'tags'], function() {
        Route::get('/', [
            'uses' => 'HomePage\TagController@index'
        ]);
    });
});



//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
