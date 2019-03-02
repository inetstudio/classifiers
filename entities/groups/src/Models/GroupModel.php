<?php

namespace InetStudio\Classifiers\Groups\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class GroupModel.
 */
class GroupModel extends Model implements GroupModelContract
{
    use SoftDeletes;
    use RevisionableTrait;
    use BuildQueryScopeTrait;

    const MATERIAL_TYPE = 'classifiers_group';

    protected $revisionCreationsEnabled = true;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'classifiers_groups';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'alias', 'description',
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
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id', 'name', 'alias',
        ];
    }

    /**
     * Сеттер атрибута name.
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strip_tags($value);
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
     * Сеттер атрибута numeric.
     *
     * @param $value
     */
    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = trim(str_replace("&nbsp;", ' ', strip_tags((isset($value['text'])) ? $value['text'] : (! is_array($value) ? $value : ''))));
    }

    /**
     * Тип материала.
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return self::MATERIAL_TYPE;
    }

    /**
     * Группы.
     */
    public function entries()
    {
        return $this->belongsToMany(
            app()->make('InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract'),
            'classifiers_groups_entries',
            'group_id',
            'entry_id'
        );
    }
}
