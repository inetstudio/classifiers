<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/classifiers',
    ],
    function () {
        Route::any('entries/data', 'DataControllerContract@data')
            ->name('back.classifiers.entries.data.index');

        Route::post('entries/suggestions/{group?}', 'UtilityControllerContract@getSuggestions')
            ->name('back.classifiers.entries.getSuggestions');

        Route::resource(
            'entries',
            'ResourceControllerContract',
            [
                'as' => 'back.classifiers',
            ]
        );
    }
);
