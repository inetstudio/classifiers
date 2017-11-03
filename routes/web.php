<?php

Route::group(['namespace' => 'InetStudio\Classifiers\Http\Controllers\Back'], function () {
    Route::group(['middleware' => 'web', 'prefix' => 'back'], function () {
        Route::group(['middleware' => 'back.auth'], function () {
            Route::post('classifiers/suggestions/{type?}', 'ClassifiersController@getSuggestions')->name('back.classifiers.getSuggestions');
            Route::any('classifiers/data', 'ClassifiersController@data')->name('back.classifiers.data');
            Route::resource('classifiers', 'ClassifiersController', ['except' => [
                'show',
            ], 'as' => 'back']);
        });
    });
});
