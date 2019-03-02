<?php

namespace InetStudio\Classifiers\Entries\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EntriesBindingsServiceProvider.
 */
class EntriesBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract' => 'InetStudio\Classifiers\Entries\Models\EntryModel',
        'InetStudio\Classifiers\Entries\Contracts\Transformers\Back\SuggestionTransformerContract' => 'InetStudio\Classifiers\Entries\Transformers\Back\SuggestionTransformer',
        'InetStudio\Classifiers\Entries\Contracts\Transformers\Back\EntryTransformerContract' => 'InetStudio\Classifiers\Entries\Transformers\Back\EntryTransformer',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Requests\Back\SaveEntryRequestContract' => 'InetStudio\Classifiers\Entries\Http\Requests\Back\SaveEntryRequest',
        'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesControllerContract' => 'InetStudio\Classifiers\Entries\Http\Controllers\Back\EntriesController',
        'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesUtilityControllerContract' => 'InetStudio\Classifiers\Entries\Http\Controllers\Back\EntriesUtilityController',
        'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesDataControllerContract' => 'InetStudio\Classifiers\Entries\Http\Controllers\Back\EntriesDataController',
        'InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyEntryEventContract' => 'InetStudio\Classifiers\Entries\Events\Back\ModifyEntryEvent',
        'InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract' => 'InetStudio\Classifiers\Entries\Services\Back\EntriesService',
        'InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesDataTableServiceContract' => 'InetStudio\Classifiers\Entries\Services\Back\EntriesDataTableService',
        'InetStudio\Classifiers\Entries\Contracts\Services\Front\EntriesServiceContract' => 'InetStudio\Classifiers\Entries\Services\Front\EntriesService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
