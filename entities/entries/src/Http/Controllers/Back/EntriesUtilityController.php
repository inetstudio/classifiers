<?php

namespace InetStudio\Classifiers\Entries\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesUtilityControllerContract;

/**
 * Class EntriesUtilityController.
 */
class EntriesUtilityController extends Controller implements EntriesUtilityControllerContract
{
    /**
     * Возвращаем значения для поля.
     *
     * @param EntriesServiceContract $entriesService
     * @param Request $request
     * @param string $group
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(EntriesServiceContract $entriesService, Request $request, string $group = ''): SuggestionsResponseContract
    {
        $search = $request->get('q');
        $type = $request->get('type');

        $data = $entriesService->getSuggestions($search, $type, $group);

        return app()->makeWith('InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract', [
            'suggestions' => $data,
        ]);
    }
}
