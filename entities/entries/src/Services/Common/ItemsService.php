<?php

namespace InetStudio\Classifiers\Entries\Services\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Common\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  EntryModelContract  $model
     */
    public function __construct(EntryModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Присваиваем классификаторы объекту.
     *
     * @param $classifiers
     *
     * @param $item
     */
    public function attachToObject($classifiers, $item)
    {
        if ($classifiers instanceof Request) {
            $classifiers = $classifiers->get('classifiers', []);
        } else {
            $classifiers = (array) $classifiers;
        }

        if (! empty($classifiers)) {
            $item->syncClassifiers($this->model::whereIn('id', $classifiers)->get());
        } else {
            $item->detachClassifiers($item->classifiers);
        }
    }

    /**
     * Возвращаем значения классификаторов объекта по группе.
     *
     * @param $item
     * @param  string  $group
     *
     * @return Collection
     */
    public function getItemEntriesByGroup($item, string $group): Collection
    {
        $values = $item->classifiers()->whereHas(
            'groups',
            function ($query) use ($group) {
                $query->where('name', '=', $group)->orWhere('alias', '=', $group);
            }
        )->get();

        return $values;
    }

    /**
     * Возвращаем значения классификаторов по группе.
     *
     * @param  string  $group
     *
     * @return Collection
     */
    public function getEntriesByGroup(string $group): Collection
    {
        $values = $this->model::whereHas(
            'groups',
            function ($query) use ($group) {
                $query->where('name', '=', $group)->orWhere('alias', '=', $group);
            }
        )->get();

        return $values;
    }

    /**
     * Возвращаем значения классификаторов для выпадающего списка по массиву алиасов.
     *
     * @param $aliases
     *
     * @return Collection
     */
    public function getEntriesByAliases($aliases): Collection
    {
        $values = $this->model::whereIn('alias', (array) $aliases)->get();

        return $values;
    }

    /**
     * Возвращаем значения классификаторов для выпадающего списка по массиву id и группе.
     *
     * @param $ids
     * @param  string  $group
     *
     * @return Collection
     */
    public function getEntriesByIDsAndGroup($ids, string $group): Collection
    {
        $values = $this->model::whereIn('id', (array) $ids)
            ->whereHas(
                'groups',
                function ($query) use ($group) {
                    $query->where('name', '=', $group)->orWhere('alias', '=', $group);
                }
            )
            ->get();

        return $values;
    }
}
