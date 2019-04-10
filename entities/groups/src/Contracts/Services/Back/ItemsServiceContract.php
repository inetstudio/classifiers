<?php

namespace InetStudio\Classifiers\Groups\Contracts\Services\Back;

use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return GroupModelContract
     */
    public function save(array $data, int $id): GroupModelContract;

    /**
     * Присваиваем группы объекту.
     *
     * @param $groupsIds
     *
     * @param $item
     */
    public function attachToObject($groupsIds, $item);
}
