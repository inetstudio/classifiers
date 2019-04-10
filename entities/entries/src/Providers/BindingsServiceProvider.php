<?php

namespace InetStudio\Classifiers\Entries\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract' => 'InetStudio\Classifiers\Entries\Models\EntryModel',
        'InetStudio\Classifiers\Entries\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\Classifiers\Entries\Transformers\Back\Utility\SuggestionTransformer',
        'InetStudio\Classifiers\Entries\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\Classifiers\Entries\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Classifiers\Entries\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Classifiers\Entries\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\Classifiers\Entries\Http\Requests\Back\SaveItemRequest',
        'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\Classifiers\Entries\Http\Controllers\Back\DataController',
        'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\Classifiers\Entries\Http\Controllers\Back\ResourceController',
        'InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\Classifiers\Entries\Http\Controllers\Back\UtilityController',
        'InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\Classifiers\Entries\Events\Back\ModifyItemEvent',
        'InetStudio\Classifiers\Entries\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\Classifiers\Entries\Services\Back\DataTableService',
        'InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\Classifiers\Entries\Services\Back\ItemsService',
        'InetStudio\Classifiers\Entries\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\Classifiers\Entries\Services\Back\UtilityService',
        'InetStudio\Classifiers\Entries\Contracts\Services\Common\ItemsServiceContract' => 'InetStudio\Classifiers\Entries\Services\Common\ItemsService',
        'InetStudio\Classifiers\Entries\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\Classifiers\Entries\Services\Front\ItemsService',
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
