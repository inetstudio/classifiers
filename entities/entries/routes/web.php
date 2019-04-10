<?php

Route::group(
    [
        'namespace' => 'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/classifiers',
    ], function () {
    Route::any('entries/data', 'EntriesDataControllerContract@data')->name('back.classifiers.entries.data.index');
    Route::post('entries/suggestions/{group?}', 'EntriesUtilityControllerContract@getSuggestions')->name(
        'back.classifiers.entries.getSuggestions'
    );

    Route::resource(
        'entries', 'EntriesControllerContract', [
        'as' => 'back.classifiers',
    ]
    );
}
);
