<?php

namespace InetStudio\Classifiers\Services\Back;

use InetStudio\Classifiers\Models\ClassifierModel;
use InetStudio\Classifiers\Contracts\Services\Back\ClassifiersServiceContract;

/**
 * Class ClassifiersService.
 */
class ClassifiersService implements ClassifiersServiceContract
{
    /**
     * Присваиваем классификаторы объекту.
     *
     * @param $request
     *
     * @param $item
     */
    public function attachToObject($request, $item)
    {
        if ($request->filled('classifiers')) {
            $item->syncClassifiers(ClassifierModel::whereIn('id', (array) $request->get('classifiers'))->get());
        } else {
            $item->detachClassifiers($item->classifiers);
        }
    }
}
