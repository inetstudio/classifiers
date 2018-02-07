<?php

namespace InetStudio\Classifiers\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\Classifiers\Models\ClassifierModel;

/**
 * Class ClassifierTransformer
 * @package InetStudio\Classifiers\Transformers\Back
 */
class ClassifierTransformer extends TransformerAbstract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param ClassifierModel $classifier
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(ClassifierModel $classifier): array
    {
        return [
            'id' => (int) $classifier->id,
            'type' => $classifier->type,
            'value' => $classifier->value,
            'alias' => $classifier->alias,
            'created_at' => (string) $classifier->created_at,
            'updated_at' => (string) $classifier->updated_at,
            'actions' => view('admin.module.classifiers::back.partials.datatables.actions', [
                'id' => $classifier->id,
            ])->render(),
        ];
    }
}
