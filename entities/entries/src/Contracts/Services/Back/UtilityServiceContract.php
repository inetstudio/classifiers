<?php

namespace InetStudio\Classifiers\Entries\Contracts\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Contracts\Services\BaseServiceContract;

/**
 * Interface UtilityServiceContract.
 */
interface UtilityServiceContract extends BaseServiceContract
{
    /**
     * Получаем подсказки.
     *
     * @param  string  $search
     * @param  string $group
     *
     * @return Collection
     */
    public function getSuggestions(string $search, string $group = ''): Collection;
}
