<?php

Route::group([
    'namespace' => 'InetStudio\Classifiers\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back'
], function () {
    Route::any('classifiers/data', 'ClassifiersDataController@data')->name('back.classifiers.data');
    Route::post('classifiers/suggestions/{type?}', 'ClassifiersUtilityController@getSuggestions')->name('back.classifiers.getSuggestions');

    Route::resource('classifiers', 'ClassifiersController', ['except' => [
        'show',
    ], 'as' => 'back']);
});
