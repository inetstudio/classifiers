<?php

namespace InetStudio\Classifiers\Entries\Services\Back;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\UtilityServiceContract;

/**
 * Class UtilityService.
 */
class UtilityService extends BaseService implements UtilityServiceContract
{
    /**
     * UtilityService constructor.
     *
     * @param  EntryModelContract  $model
     */
    public function __construct(EntryModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем подсказки.
     *
     * @param  string  $search
     * @param  string $group
     *
     * @return Collection
     */
    public function getSuggestions(string $search, string $group = ''): Collection
    {
        $builder = $this->model::where(
            [
                ['value', 'LIKE', '%'.$search.'%'],
            ]
        );

        if ($group) {
            $builder->whereHas(
                'groups',
                function ($query) use ($group) {
                    $query->where('name', '=', $group)->orWhere('alias', '=', $group);
                }
            );
        }

        $items = $builder->get();

        return $items;
    }
}
