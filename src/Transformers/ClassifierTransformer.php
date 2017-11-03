<?php

namespace Inetstudio\Classifiers\Transformers;

use League\Fractal\TransformerAbstract;
use InetStudio\Classifiers\Models\ClassifierModel;

class ClassifierTransformer extends TransformerAbstract
{
    /**
     * @param ClassifierModel $classifier
     * @return array
     */
    public function transform(ClassifierModel $classifier)
    {
        return [
            'id' => (int) $classifier->id,
            'type' => $classifier->type,
            'value' => $classifier->value,
            'created_at' => (string) $classifier->created_at,
            'updated_at' => (string) $classifier->updated_at,
            'actions' => view('admin.module.classifiers::partials.datatables.actions', [
                'id' => $classifier->id,
            ])->render(),
        ];
    }
}
