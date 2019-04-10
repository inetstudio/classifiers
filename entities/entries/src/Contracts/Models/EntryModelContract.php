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
}
