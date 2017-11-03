<?php

namespace InetStudio\Classifiers\Http\Controllers\Back\Traits;

use InetStudio\Classifiers\Models\ClassifierModel;

trait ClassifiersManipulationsTrait
{
    /**
     * Сохраняем классификаторы.
     *
     * @param $item
     * @param $request
     */
    private function saveClassifiers($item, $request)
    {
        if ($request->filled('classifiers')) {
            $item->syncClassifiers(ClassifierModel::whereIn('id', (array) $request->get('classifiers'))->get());
        } else {
            $item->detachClassifiers($item->classifiers);
        }
    }
}
