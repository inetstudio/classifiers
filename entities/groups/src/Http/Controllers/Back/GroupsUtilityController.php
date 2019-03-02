<?php

namespace InetStudio\Classifiers\Groups\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\GroupsUtilityControllerContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Class GroupsUtilityController.
 */
class GroupsUtilityController extends Controller implements GroupsUtilityControllerContract
{
    /**
     * Возвращаем статьи для поля.
     *
     * @param GroupsServiceContract $groupsService
     * @param Request $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(GroupsServiceContract $groupsService, Request $request): SuggestionsResponseContract
    {
        $search = $request->get('q');
        $type = $request->get('type');

        $data = $groupsService->getSuggestions($search, $type);

        return app()->makeWith(SuggestionsResponseContract::class, [
            'suggestions' => $data,
        ]);
    }
}
