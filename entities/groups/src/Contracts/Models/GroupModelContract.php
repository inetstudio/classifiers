<?php

namespace InetStudio\Classifiers\Groups\Contracts\Models;

use ArrayAccess;
use JsonSerializable;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Queue\QueueableEntity;

/**
 * Interface GroupModelContract.
 */
interface GroupModelContract extends ArrayAccess, Arrayable, Auditable, Jsonable, JsonSerializable, QueueableEntity, UrlRoutable
{
}
