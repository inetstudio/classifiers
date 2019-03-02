<?php

namespace InetStudio\Classifiers\Groups\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Transformers\Back\GroupTransformerContract;

/**
 * Class GroupTransformer.
 */
class GroupTransformer extends TransformerAbstract implements GroupTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param GroupModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(GroupModelContract $item): array
    {
        return [
            'id' => (int) $item->id,
            'name' => $item->name,
            'alias' => $item->alias,
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
            'actions' => view('admin.module.classifiers.groups::back.partials.datatables.actions', compact('item'))
                ->render(),
        ];
    }
}
