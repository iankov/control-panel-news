<?php

Route::get('/news', ['as' => 'news', 'uses' => 'NewsController@index']);
Route::group(['prefix' => 'news', 'as' => 'news.'], function(){
    Route::get('/json', ['as' => 'json', 'uses' => 'NewsController@jsonIndex']);
    Route::get('{id}/view', ['as' => 'view', 'uses' => 'NewsController@view']);
    Route::get('create', ['as' => 'create', 'uses' => 'NewsController@create']);
    Route::post('/', ['as' => 'store', 'uses' => 'NewsController@store']);
    Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'NewsController@edit']);
    Route::put('{id}', ['as' => 'update', 'uses' => 'NewsController@update']);
    Route::put('{id}/active/toggle', ['as' => 'active.toggle', 'uses' => 'NewsController@toggleActive']);
    Route::delete('{id?}', ['as' => 'delete', 'uses' => 'NewsController@delete'])->where(['id' => '[0-9]+']);

    Route::get('categories', ['as' => 'categories', 'uses' => 'NewsCategoryController@index']);
    Route::get('/categories/json', ['as' => 'categories.json', 'uses' => 'NewsCategoryController@jsonIndex']);
    Route::group(['prefix' => 'category', 'as' => 'category.'], function() {
        Route::get('create', ['as' => 'create', 'uses' => 'NewsCategoryController@create']);
        Route::post('/', ['as' => 'store', 'uses' => 'NewsCategoryController@store']);
        Route::get('{id}/edit', ['as' => 'edit', 'uses' => 'NewsCategoryController@edit']);
        Route::put('{id}', ['as' => 'update', 'uses' => 'NewsCategoryController@update']);
        Route::put('{id}/active/toggle', ['as' => 'active.toggle', 'uses' => 'NewsCategoryController@toggleActive']);
        Route::delete('{id?}', ['as' => 'delete', 'uses' => 'NewsCategoryController@delete'])->where(['id' => '[0-9]+']);
    });
});