<?php

namespace InetStudio\Classifiers\Entries\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Transformers\Back\EntryTransformerContract;

/**
 * Class EntryTransformer.
 */
class EntryTransformer extends TransformerAbstract implements EntryTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param EntryModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(EntryModelContract $item): array
    {
        return [
            'groups' => view('admin.module.classifiers.entries::back.partials.datatables.groups', [
                'groups' => $item->groups,
            ])->render(),
            'value' => $item->value,
            'alias' => $item->alias,
            'created_at' => (string) $item->created_at,
            'updated_at' => (string) $item->updated_at,
            'actions' => view('admin.module.classifiers.entries::back.partials.datatables.actions', [
                'id' => $item->id,
            ])->render(),
        ];
    }
}
