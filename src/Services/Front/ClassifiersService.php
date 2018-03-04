<?php

namespace InetStudio\Classifiers\Services\Front;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use InetStudio\Classifiers\Models\ClassifierModel;

/**
 * Class ClassifiersService.
 */
class ClassifiersService
{
    /**
     * Получаем классификаторы по типу или значению.
     *
     * @param string $type
     * @param string $value
     * @param string $alias
     *
     * @return Collection
     */
    public function getClassifiers(string $type = '', string $value = '', string $alias = ''): Collection
    {
        $cacheKey = 'ClassifiersService_getClassifiersByTypeOrValue_'.md5($type.'_'.$value.'_'.$alias);

        return Cache::tags(['classifiers'])->remember($cacheKey, 1440, function () use ($type, $value, $alias) {
            $items = ClassifierModel::select(['id', 'type', 'value', 'alias']);

            if ($type) {
                $items = $items->where('type', $type);
            }

            if ($value) {
                $items = $items->where('value', $value);
            }

            if ($alias) {
                $items = $items->where('alias', $alias);
            }

            return $items->get();
        });
    }

    /**
     * Получаем классификаторы по типу.
     *
     * @param string $type
     *
     * @return Collection
     */
    public function getClassifiersByType(string $type = ''): Collection
    {
        return $this->getClassifiers($type, '', '');
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
