<?php

namespace InetStudio\Classifiers\Entries\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class EntryModel.
 */
class EntryModel extends Model implements EntryModelContract, Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use BuildQueryScopeTrait;

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
            'entry_model_id',
            'group_model_id'
        );
    }
}
