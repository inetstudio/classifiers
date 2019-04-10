<?php

namespace InetStudio\Classifiers\Entries\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\Classifiers\Entries\Services\Common\ItemsService as CommonItemsService;

/**
 * Class ItemsService.
 */
class ItemsService extends CommonItemsService implements ItemsServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return EntryModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): EntryModelContract
    {
        $groupsService = app()->make('InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract');

        $action = ($id) ? 'отредактирована' : 'создана';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        $groupsData = collect(Arr::get($data, 'groups', []));
        $groupsService->attachToObject($groupsData, $item);

        event(
            app()->makeWith(
                'InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Запись успешно '.$action);

        return $item;
    }
}
