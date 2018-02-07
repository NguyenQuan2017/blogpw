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
            'uses' => 'DashboardController@index'
        ]);

        Route::post('/ip', [
            'uses' => 'AuthController@getIp'
        ]);
        Route::group(['prefix' =>'categories'], function () {

           Route::get('/', [
               'uses' => 'DashboardController@getCategories'
           ]);
           Route::post('/', [
                'uses' => 'DashboardController@createCategories'
           ]);
           Route::put('{id}', [
                'uses' => 'DashboardController@updateCategories'
           ]);
            Route::delete('{id}', [
                'uses' => 'DashboardController@deleteCategories'
            ]);

        });

        Route::group(['prefix' => 'posts'], function () {

            Route::get('/', [
                'uses' => 'DashboardController@getAllPost'
            ]);
            Route::get('{id}/categories', [
                'uses' => 'DashboardController@getCate'
            ]);
            Route::post('/',[
                'uses' => 'DashboardController@createPost'
            ]);
            Route::put('{id}', [
                'uses' => 'DashboardController@updatePost'
            ]);
            Route::delete('{id}', [
                'uses' => 'DashboardController@deletePost'
            ]);
        });

        Route::group(['prefix' => 'tags'],function() {
            Route::get('/', [
                'uses' => 'DashboardController@getTag'
            ]);
            Route::post('/', [
                'uses' => 'DashboardController@createTag'
            ]);
            Route::put('{id}', [
                'uses' => 'DashboardController@updateTag'
            ]);
            Route::delete('{id}', [
                'uses' => 'DashboardController@deleteTag'
            ]);
        });
    });
});

Route::group(['prefix' => 'homepages'], function () {

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [
            'uses' => 'CategoryController@index'
        ]);

    });

    Route::group(['prefix' => 'posts'], function () {
        Route::get('/', [
            'uses' => 'PostController@index'
        ]);
        Route::get('{id}/detail', [
            'uses' => 'PostController@show'
        ]);
        Route::post('{id}/counter',[
            'uses' => 'PostController@counter'
        ]);
        Route::get('/popular', [
            'uses' => 'PostController@popular'
        ]);
        Route::get('/recent',[
            'uses' => 'PostController@recent'
        ]);
        Route::get('/{keyword}/search', [
            'uses' => 'PostController@search'
        ]);
//        Route::get('/{keyword}/tags', [
//            'uses' => 'PostController@postTag'
//        ]);
    });

    Route::group(['prefix' => 'tags'], function() {
        Route::get('/', [
            'uses' => 'TagController@index'
        ]);
    });
});



//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
