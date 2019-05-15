<?php

namespace InetStudio\Classifiers\Entries\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\UtilityControllerContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class UtilityController.
 */
class UtilityController extends Controller implements UtilityControllerContract
{
    /**
     * Возвращаем классификаторы для поля.
     *
     * @param  UtilityServiceContract  $utilityService
     * @param  Request  $request
     * @param  string $group
     *
     * @return SuggestionsResponseContract
     *
     * @throws BindingResolutionException
     */
    public function getSuggestions(UtilityServiceContract $utilityService, Request $request, string $group = ''): SuggestionsResponseContract
    {
        $search = $request->get('q', '') ?? '';
        $type = $request->get('type', '') ?? '';

        $items = $utilityService->getSuggestions($search, $group);

        return $this->app->make(SuggestionsResponseContract::class, compact('items', 'type'));
    }
}
