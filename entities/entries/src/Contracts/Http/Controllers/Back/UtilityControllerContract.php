<?php

namespace InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Interface UtilityControllerContract.
 */
interface UtilityControllerContract
{
    /**
     * Возвращаем классификаторы для поля.
     *
     * @param  UtilityServiceContract  $utilityService
     * @param  Request  $request
     * @param  string $group
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(
        UtilityServiceContract $utilityService,
        Request $request,
        string $group = ''
    ): SuggestionsResponseContract;
}
