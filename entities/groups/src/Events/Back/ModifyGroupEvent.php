<?php

namespace InetStudio\Classifiers\Groups\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Classifiers\Groups\Contracts\Events\Back\ModifyGroupEventContract;

/**
 * Class ModifyGroupEvent.
 */
class ModifyGroupEvent implements ModifyGroupEventContract
{
    use SerializesModels;

    public $object;

    /**
     * ModifyGroupEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
