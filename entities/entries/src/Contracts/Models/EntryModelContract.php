<?php

namespace InetStudio\Classifiers\Entries\Contracts\Models;

use ArrayAccess;
use JsonSerializable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

/**
 * Interface EntryModelContract.
 */
interface EntryModelContract extends ArrayAccess, Arrayable, Auditable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
    /**
     * Reload a fresh model instance from the database.
     *
     * @param  array|string  $with
     *
     * @return static|null
     */
    public function fresh($with = []);
}
