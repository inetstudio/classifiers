<?php

namespace InetStudio\Classifiers\Services\Front;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use InetStudio\Classifiers\Models\ClassifierModel;

class ClassifiersService
{
    /**
     * Получаем классификаторы по типу или значению.
     *
     * @param string $type
     * @param string $value
     * @return Collection
     */
    public function getClassifiersByTypeOrValue(string $type = '', string $value = ''): Collection
    {
        $cacheKey = 'ClassifiersService_getClassifiersByTypeOrValue_'.md5($type.$value);

        return Cache::tags(['classifiers'])->remember($cacheKey, 1440, function() use ($type, $value) {
            $items = ClassifierModel::select(['id', 'type', 'value']);

            if ($type) {
                $items = $items->where('type', $type);
            }

            if ($value) {
                $items = $items->where('value', $value);
            }

            return $items->get();
        });
    }
}
