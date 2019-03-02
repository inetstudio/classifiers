<?php

Route::group([
    'namespace' => 'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back/classifiers',
], function () {
    Route::any('groups/data', 'GroupsDataControllerContract@data')->name('back.classifiers.groups.data.index');
    Route::post('groups/suggestions', 'GroupsUtilityControllerContract@getSuggestions')->name('back.classifiers.groups.getSuggestions');

    Route::resource('groups', 'GroupsControllerContract', ['except' => [
        'show',
    ], 'as' => 'back.classifiers']);
});
