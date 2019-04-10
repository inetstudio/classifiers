<?php

namespace InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back;

use Illuminate\Http\Request;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\UtilityServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Utility\SuggestionsResponseContract;

/**
 * Interface UtilityControllerContract.
 */
interface UtilityControllerContract
{
    /**
     * Возвращаем опросы для поля.
     *
     * @param  UtilityServiceContract  $utilityService
     * @param  Request  $request
     *
     * @return SuggestionsResponseContract
     */
    public function getSuggestions(
        UtilityServiceContract $utilityService,
        Request $request
    ): SuggestionsResponseContract;
}
