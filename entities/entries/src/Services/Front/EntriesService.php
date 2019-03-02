<?php

namespace InetStudio\Classifiers\Entries\Services\Front;

use Illuminate\Database\Eloquent\Collection;
use InetStudio\AdminPanel\Base\Services\Front\BaseService;
use InetStudio\Classifiers\Entries\Contracts\Services\Front\EntriesServiceContract;

/**
 * Class EntriesService.
 */
class EntriesService extends BaseService implements EntriesServiceContract
{
    /**
     * EntriesService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract'));
    }

    /**
     * Получаем классификаторы по типу или значению.
     *
     * @param string $group
     * @param string $value
     * @param string $alias
     *
     * @return Collection
     */
    public function getClassifiers(string $group = '', string $value = '', string $alias = ''): Collection
    {
        $items = $this->model::buildQuery();

        if ($group) {
            $items = $items->where('group', $group);
        }

        if ($value) {
            $items = $items->where('value', $value);
        }

        if ($alias) {
            $items = $items->where('alias', $alias);
        }

        return $items->get();
    }

    /**
     * Получаем классификаторы по типу.
     *
     * @param string $group
     *
     * @return Collection
     */
    public function getClassifiersByGroup(string $group = ''): Collection
    {
        return $this->getClassifiers($group);
    }

    /**
     * Получаем классификаторы по значению.
     *
     * @param string $value
     *
     * @return Collection
     */
    public function getClassifiersByValue(string $value = ''): Collection
    {
        return $this->getClassifiers('', $value, '');
    }

    /**
     * Получаем классификаторы по алиасу.
     *
     * @param string $alias
     *
     * @return Collection
     */
    public function getClassifierByAlias(string $alias = ''): Collection
    {
        return $this->getClassifiers('', '', $alias)->first();
    }
}
