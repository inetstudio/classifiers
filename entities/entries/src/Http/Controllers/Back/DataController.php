<?php

namespace InetStudio\Classifiers\Entries\Http\Controllers\Back;

use Illuminate\Http\JsonResponse;
use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\DataControllerContract;

/**
 * Class DataController.
 */
class DataController extends Controller implements DataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param  DataTableServiceContract  $datatablesService
     *
     * @return JsonResponse
     */
    public function data(DataTableServiceContract $datatablesService): JsonResponse
    {
        return $datatablesService->ajax();
    }
}
