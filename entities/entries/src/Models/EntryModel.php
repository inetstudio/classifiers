<?php

namespace InetStudio\Classifiers\Entries\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class EntryModel.
 */
class EntryModel extends Model implements EntryModelContract
{
    use SoftDeletes;
    use RevisionableTrait;
    use BuildQueryScopeTrait;

    protected $revisionCreationsEnabled = true;

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
        'value', 'alias',
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
            'id', 'value', 'alias',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'groups' => function ($query) {
                $query->select(['id', 'name', 'alias']);
            },
        ];
    }

    /**
     * Группы.
     */
    public function groups()
    {
        return $this->belongsToMany(
            app()->make('InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract'),
            'classifiers_groups_entries',
            'entry_id',
            'group_id'
        );
    }
}
