<?php

namespace InetStudio\Classifiers\Listeners;

use Illuminate\Support\Facades\Cache;

/**
 * Class ClearClassifiersCacheListener
 * @package InetStudio\Classifiers\Listeners
 */
class ClearClassifiersCacheListener
{
    /**
     * ClearClassifiersCacheListener constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param $event
     */
    public function handle($event): void
    {
        $object = $event->object;

        Cache::tags(['classifiers'])->forget('ClassifiersService_getClassifiersByTypeOrValue_'.md5($object->type));
        Cache::tags(['classifiers'])->forget('ClassifiersService_getClassifiersByTypeOrValue_'.md5($object->type.$object->value));
    }
}
