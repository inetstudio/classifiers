<?php

namespace InetStudio\Classifiers\Entries\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class EntryModel.
 */
class EntryModel extends Model implements EntryModelContract
{
    use Auditable;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    const MATERIAL_TYPE = 'classifiers_entry';

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'classifiers_entries';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'value',
        'alias',
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

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'value',
            'alias',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'groups' => function ($query) {
                $query->select(['id', 'name', 'alias']);
            },
        ];
    }

    /**
     * Сеттер атрибута value.
     *
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = strip_tags($value);
    }

    /**
     * Сеттер атрибута alias.
     *
     * @param $value
     */
    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = strip_tags($value);
    }

    /**
     * Тип материала.
     *
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return self::MATERIAL_TYPE;
    }

    /**
     * Группы.
     *
     * @return BelongsToMany
     *
     * @throws BindingResolutionException
     */
    public function groups(): BelongsToMany
    {
        $groupModel = app()->make('InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract');

        return $this->belongsToMany(
            get_class($groupModel),
            'classifiers_groups_entries',
            'entry_model_id',
            'group_model_id'
        );
    }
}
