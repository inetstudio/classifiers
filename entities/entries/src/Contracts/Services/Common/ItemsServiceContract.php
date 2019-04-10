<?php

namespace InetStudio\Classifiers\Entries\Contracts\Services\Common;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends BaseServiceContract
{
    /**
     * Присваиваем классификаторы объекту.
     *
     * @param $classifiers
     *
     * @param $item
     */
    public function attachToObject($classifiers, $item);

    /**
     * Возвращаем значения классификаторов объекта по группе.
     *
     * @param $item
     * @param  string  $group
     *
     * @return Collection
     */
    public function getItemEntriesByGroup($item, string $group): Collection;

    /**
     * Возвращаем значения классификаторов по группе.
     *
     * @param  string  $group
     *
     * @return Collection
     */
    public function getEntriesByGroup(string $group): Collection;

    /**
     * Возвращаем значения классификаторов для выпадающего списка по массиву алиасов.
     *
     * @param $aliases
     *
     * @return Collection
     */
    public function getEntriesByAliases($aliases): Collection;

    /**
     * Возвращаем значения классификаторов для выпадающего списка по массиву id и группе.
     *
     * @param $ids
     * @param  string  $group
     *
     * @return Collection
     */
    public function getEntriesByIdsAndGroup($ids, string $group): Collection;
}
