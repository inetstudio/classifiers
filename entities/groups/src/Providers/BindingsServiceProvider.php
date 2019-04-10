<?php

namespace InetStudio\Classifiers\Groups\Providers;

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
        'InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract' => 'InetStudio\Classifiers\Groups\Models\GroupModel',
        'InetStudio\Classifiers\Groups\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\Classifiers\Groups\Transformers\Back\Resource\IndexTransformer',
        'InetStudio\Classifiers\Groups\Contracts\Transformers\Back\Utility\SuggestionTransformerContract' => 'InetStudio\Classifiers\Groups\Transformers\Back\Utility\SuggestionTransformer',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\Classifiers\Groups\Http\Requests\Back\SaveItemRequest',
        'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\Classifiers\Groups\Http\Controllers\Back\DataController',
        'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\Classifiers\Groups\Http\Controllers\Back\ResourceController',
        'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\UtilityControllerContract' => 'InetStudio\Classifiers\Groups\Http\Controllers\Back\UtilityController',
        'InetStudio\Classifiers\Groups\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\Classifiers\Groups\Events\Back\ModifyItemEvent',
        'InetStudio\Classifiers\Groups\Contracts\Services\Back\DataTableServiceContract' => 'InetStudio\Classifiers\Groups\Services\Back\DataTableService',
        'InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\Classifiers\Groups\Services\Back\ItemsService',
        'InetStudio\Classifiers\Groups\Contracts\Services\Back\UtilityServiceContract' => 'InetStudio\Classifiers\Groups\Services\Back\UtilityService',
        'InetStudio\Classifiers\Groups\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\Classifiers\Groups\Services\Front\ItemsService',
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
