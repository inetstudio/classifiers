<?php

namespace InetStudio\Classifiers\Events;

use Illuminate\Queue\SerializesModels;

/**
 * Class ModifyClassifierEvent
 * @package InetStudio\Classifiers\Events
 */
class ModifyClassifierEvent
{
    use SerializesModels;

    public $object;

    /**
     * Create a new event instance.
     *
     * ModifyClassifierEvent constructor.
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
