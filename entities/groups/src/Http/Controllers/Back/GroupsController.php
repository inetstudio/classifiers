<?php

namespace InetStudio\Classifiers\Groups\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Requests\Back\SaveGroupRequestContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsDataTableServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\GroupsControllerContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class GroupsController.
 */
class GroupsController extends Controller implements GroupsControllerContract
{
    /**
     * Список объектов.
     *
     * @param GroupsDataTableServiceContract $dataTableService
     * 
     * @return IndexResponseContract
     */
    public function index(GroupsDataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Добавление объекта.
     *
     * @param GroupsServiceContract $groupsService
     *
     * @return FormResponseContract
     */
    public function create(GroupsServiceContract $groupsService): FormResponseContract
    {
        $item = $groupsService->getItemById();

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param GroupsServiceContract $groupsService
     * @param SaveGroupRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(GroupsServiceContract $groupsService, SaveGroupRequestContract $request): SaveResponseContract
    {
        return $this->save($groupsService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param GroupsServiceContract $groupsService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(GroupsServiceContract $groupsService, int $id = 0): FormResponseContract
    {
        $item = $groupsService->getItemById($id, [
            'columns' => ['description'],
        ]);

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param GroupsServiceContract $groupsService
     * @param SaveGroupRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(GroupsServiceContract $groupsService, SaveGroupRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($groupsService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param GroupsServiceContract $groupsService
     * @param SaveGroupRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    private function save(GroupsServiceContract $groupsService, SaveGroupRequestContract $request, int $id = 0): SaveResponseContract
    {
        $data = $request->only($groupsService->model->getFillable());

        $item = $groupsService->save($data, $id);

        return app()->makeWith(SaveResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param GroupsServiceContract $groupsService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(GroupsServiceContract $groupsService, int $id = 0): DestroyResponseContract
    {
        $result = $groupsService->destroy($id);

        return app()->makeWith(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
