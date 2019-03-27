<?php

namespace InetStudio\Classifiers\Entries\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Requests\Back\SaveEntryRequestContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesDataTableServiceContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Controllers\Back\EntriesControllerContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class EntriesController.
 */
class EntriesController extends Controller implements EntriesControllerContract
{
    /**
     * Список объектов.
     *
     * @param EntriesDataTableServiceContract $datatablesService
     * 
     * @return IndexResponseContract
     */
    public function index(EntriesDataTableServiceContract $datatablesService): IndexResponseContract
    {
        $table = $datatablesService->html();

        return app()->makeWith(IndexResponseContract::class, [
            'data' => compact('table'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param EntriesServiceContract $entriesService
     * 
     * @return FormResponseContract
     */
    public function create(EntriesServiceContract $entriesService): FormResponseContract
    {
        $item = $entriesService->getItemByID();

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param EntriesServiceContract $entriesService
     * @param SaveEntryRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(EntriesServiceContract $entriesService, SaveEntryRequestContract $request): SaveResponseContract
    {
        return $this->save($entriesService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param EntriesServiceContract $entriesService
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(EntriesServiceContract $entriesService, int $id = 0): FormResponseContract
    {
        $item = $entriesService->getItemByID($id);

        return app()->makeWith(FormResponseContract::class, [
            'data' => compact('item'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param EntriesServiceContract $entriesService
     * @param SaveEntryRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(EntriesServiceContract $entriesService, SaveEntryRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($entriesService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param EntriesServiceContract $entriesService
     * @param SaveEntryRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(EntriesServiceContract $entriesService, SaveEntryRequestContract $request, int $id = 0): SaveResponseContract
    {
        $data = $request->only($entriesService->model->getFillable());
        $data['groups'] = $request->get('groups') ?? [];

        $item = $entriesService->save($data, $id);

        return app()->makeWith(SaveResponseContract::class, [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param EntriesServiceContract $entriesService
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(EntriesServiceContract $entriesService, int $id = 0): DestroyResponseContract
    {
        $result = $entriesService->destroy($id);

        return app()->makeWith(DestroyResponseContract::class, [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
