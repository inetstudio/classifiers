<?php

namespace InetStudio\Classifiers\Groups\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var GroupModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  GroupModelContract  $item
     */
    public function __construct(GroupModelContract $item)
    {
        $this->item = $item;
    }
}
