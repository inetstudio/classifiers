<?php

namespace InetStudio\Classifiers\Groups\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  GroupModelContract  $model
     */
    public function __construct(GroupModelContract $model)
    {
        parent::__construct($model);
    }
}
