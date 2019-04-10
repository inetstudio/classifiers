<?php

namespace InetStudio\Classifiers\Entries\Contracts\Transformers\Back\Resource;

use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  EntryModelContract  $item
     *
     * @return array
     */
    public function transform(EntryModelContract $item): array;
}
