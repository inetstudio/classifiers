<?php

namespace InetStudio\Classifiers\Entries\Contracts\Services\Back;

use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Common\ItemsServiceContract as CommonItemsServiceContract;

/**
 * Interface ItemsServiceContract.
 */
interface ItemsServiceContract extends CommonItemsServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return EntryModelContract
     */
    public function save(array $data, int $id): EntryModelContract;
}
