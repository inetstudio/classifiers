<?php

namespace InetStudio\Classifiers\Entries\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var EntryModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param EntryModelContract $item
     */
    public function __construct(EntryModelContract $item)
    {
        $this->item = $item;
    }
}
