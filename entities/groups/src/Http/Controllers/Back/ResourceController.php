<?php

namespace InetStudio\Classifiers\Groups\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\DataTableServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Requests\Back\SaveItemRequestContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Controllers\Back\ResourceControllerContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\FormResponseContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\SaveResponseContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\DestroyResponseContract;

/**
 * Class ResourceController.
 */
class ResourceController extends Controller implements ResourceControllerContract
{
    /**
     * Список объектов.
     *
     * @param  DataTableServiceContract  $dataTableService
     *
     * @return IndexResponseContract
     *
     * @throws BindingResolutionException
     */
    public function index(DataTableServiceContract $dataTableService): IndexResponseContract
    {
        $table = $dataTableService->html();

        return $this->app->make(
            IndexResponseContract::class, 
            [
                'data' => compact('table'),
            ]
        );
    }

    /**
     * Создание объекта.
     *
     * @param  ItemsServiceContract  $groupsService
     *
     * @return FormResponseContract
     *
     * @throws BindingResolutionException
     */
    public function create(ItemsServiceContract $groupsService): FormResponseContract
    {
        $item = $groupsService->getItemById();

        return $this->app->make(
            FormResponseContract::class,
            [
                'data' => compact('item'),
            ]
        );
    }

    /**
     * Создание объекта.
     *
     * @param  ItemsServiceContract  $groupsService
     * @param  SaveItemRequestContract  $request
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    public function store(ItemsServiceContract $groupsService, SaveItemRequestContract $request): SaveResponseContract
    {
        return $this->save($groupsService, $request);
    }

    /**
     * Редактирование объекта.
     *
     * @param  ItemsServiceContract  $groupsService
     * @param  int  $id
     *
     * @return FormResponseContract
     *
     * @throws BindingResolutionException
     */
    public function edit(ItemsServiceContract $groupsService, int $id = 0): FormResponseContract
    {
        $item = $groupsService->getItemById(
            $id, [
            'columns' => ['description'],
        ]
        );

        return $this->app->make(
            FormResponseContract::class,
            [
                'data' => compact('item'),
            ]
        );
    }

    /**
     * Обновление объекта.
     *
     * @param  ItemsServiceContract  $groupsService
     * @param  SaveItemRequestContract  $request
     * @param  int  $id
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    public function update(
        ItemsServiceContract $groupsService,
        SaveItemRequestContract $request,
        int $id = 0
    ): SaveResponseContract {
        return $this->save($groupsService, $request, $id);
    }

    /**
     * Сохранение объекта.
     *
     * @param  ItemsServiceContract  $groupsService
     * @param  SaveItemRequestContract  $request
     * @param  int  $id
     *
     * @return SaveResponseContract
     *
     * @throws BindingResolutionException
     */
    private function save(
        ItemsServiceContract $groupsService,
        SaveItemRequestContract $request,
        int $id = 0
    ): SaveResponseContract {
        $data = $request->only($groupsService->model->getFillable());

        $item = $groupsService->save($data, $id);

        return $this->app->make(
            SaveResponseContract::class,
            compact('item')
        );
    }

    /**
     * Удаление объекта.
     *
     * @param  ItemsServiceContract  $groupsService
     * @param  int  $id
     *
     * @return DestroyResponseContract
     *
     * @throws BindingResolutionException
     */
    public function destroy(ItemsServiceContract $groupsService, int $id = 0): DestroyResponseContract
    {
        $result = $groupsService->destroy($id);

        return $this->app->make(
            DestroyResponseContract::class,
            [
                'result' => ($result === null) ? false : $result,
            ]
        );
    }
}
