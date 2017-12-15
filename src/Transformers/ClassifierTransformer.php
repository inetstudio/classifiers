<?php

namespace Inetstudio\Classifiers\Transformers;

use League\Fractal\TransformerAbstract;
use InetStudio\Classifiers\Models\ClassifierModel;

class ClassifierTransformer extends TransformerAbstract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param ClassifierModel $classifier
     * @return array
     */
    public function transform(ClassifierModel $classifier): array
    {
        return [
            'id' => (int) $classifier->id,
            'type' => $classifier->type,
            'value' => $classifier->value,
            'created_at' => (string) $classifier->created_at,
            'updated_at' => (string) $classifier->updated_at,
            'actions' => view('admin.module.classifiers::back.partials.datatables.actions', [
                'id' => $classifier->id,
            ])->render(),
        ];
    }
}
