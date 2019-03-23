<?php

namespace InetStudio\Classifiers\Groups\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class GroupsBindingsServiceProvider.
 */
class GroupsBindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract' => 'InetStudio\Classifiers\Groups\Models\GroupModel',
        'InetStudio\Classifiers\Groups\Contracts\Transformers\Back\GroupTransformerContract' => 'InetStudio\Classifiers\Groups\Transformers\Back\GroupTransformer',
        'InetStudio\Classifiers\Groups\Contracts\Transformers\Back\SuggestionTransformerContract' => 'InetStudio\Classifiers\Groups\Transformers\Back\SuggestionTransformer',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\FormResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Resource\FormResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract' => 'InetStudio\Classifiers\Groups\Http\Responses\Back\Utility\SuggestionsResponse',
        'InetStudio\Classifiers\Groups\Contracts\Http\Requests\Back\SaveGroupRequestContract' => 'InetStudio\Classifiers\Groups\Http\Requests\Back\SaveGroupRequest',
        'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\GroupsDataControllerContract' => 'InetStudio\Classifiers\Groups\Http\Controllers\Back\GroupsDataController',
        'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\GroupsControllerContract' => 'InetStudio\Classifiers\Groups\Http\Controllers\Back\GroupsController',
        'InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\GroupsUtilityControllerContract' => 'InetStudio\Classifiers\Groups\Http\Controllers\Back\GroupsUtilityController',
        'InetStudio\Classifiers\Groups\Contracts\Events\Back\ModifyGroupEventContract' => 'InetStudio\Classifiers\Groups\Events\Back\ModifyGroupEvent',
        'InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsDataTableServiceContract' => 'InetStudio\Classifiers\Groups\Services\Back\GroupsDataTableService',
        'InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract' => 'InetStudio\Classifiers\Groups\Services\Back\GroupsService',
        'InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsObserverServiceContract' => 'InetStudio\Classifiers\Groups\Services\Back\GroupsObserverService',
        'InetStudio\Classifiers\Groups\Contracts\Services\Front\GroupsServiceContract' => 'InetStudio\Classifiers\Groups\Services\Front\GroupsService',
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
