<?php

namespace InetStudio\Classifiers\Groups\Contracts\Transformers\Back\Resource;

use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  GroupModelContract  $item
     *
     * @return array
     */
    public function transform(GroupModelContract $item): array;
}
