<?php

namespace InetStudio\Classifiers\Groups\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsDataTableServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\GroupsDataControllerContract;

/**
 * Class GroupsDataController.
 */
class GroupsDataController extends Controller implements GroupsDataControllerContract
{
    /**
     * Получаем данные для отображения в таблице.
     *
     * @param GroupsDataTableServiceContract $dataTableService
     *
     * @return mixed
     */
    public function data(GroupsDataTableServiceContract $dataTableService)
    {
        return $dataTableService->ajax();
    }
}
