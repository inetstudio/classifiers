<?php

namespace InetStudio\Classifiers\Groups\Services\Front;

use InetStudio\AdminPanel\Base\Services\Front\BaseService;
use InetStudio\Classifiers\Groups\Contracts\Services\Front\GroupsServiceContract;

/**
 * Class GroupsService.
 */
class GroupsService extends BaseService implements GroupsServiceContract
{
    /**
     * GroupsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract'));
    }
}
