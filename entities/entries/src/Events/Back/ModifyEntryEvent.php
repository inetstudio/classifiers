<?php

namespace InetStudio\Classifiers\Entries\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyEntryEventContract;

/**
 * Class ModifyEntryEvent.
 */
class ModifyEntryEvent implements ModifyEntryEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyEntryEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
