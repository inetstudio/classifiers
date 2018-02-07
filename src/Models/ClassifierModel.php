<?php

namespace InetStudio\Classifiers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * InetStudio\Classifiers\Models\ClassifierModel
 *
 * @property string|null $alias
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property int $id
 * @property string $type
 * @property \Carbon\Carbon|null $updated_at
 * @property string $value
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\InetStudio\Classifiers\Models\ClassifierModel onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\InetStudio\Classifiers\Models\ClassifierModel whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\InetStudio\Classifiers\Models\ClassifierModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\InetStudio\Classifiers\Models\ClassifierModel withoutTrashed()
 * @mixin \Eloquent
 */
class ClassifierModel extends Model
{
    use SoftDeletes;
    use RevisionableTrait;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'classifiers';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'value', 'alias',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $revisionCreationsEnabled = true;
}
