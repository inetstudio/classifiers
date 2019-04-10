<?php

Route::group(
    [
        'namespace' => 'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/classifiers',
    ],
    function () {
        Route::any('groups/data', 'DataControllerContract@data')
            ->name('back.classifiers.groups.data.index');

        Route::post('groups/suggestions', 'UtilityControllerContract@getSuggestions')
            ->name('back.classifiers.groups.getSuggestions');

        Route::resource(
            'groups',
            'ResourceControllerContract',
            [
                'except' => [
                    'show',
                ],
                'as' => 'back.classifiers',
            ]
        );
    }
);
