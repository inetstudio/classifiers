<?php

namespace InetStudio\Classifiers\Groups\Services\Back;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\Classifiers\Groups\Contracts\Repositories\GroupsRepositoryContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsDataTableServiceContract;

/**
 * Class GroupsDataTableService.
 */
class GroupsDataTableService extends DataTable implements GroupsDataTableServiceContract
{
    /**
     * @var
     */
    public $model;

    /**
     * CommentsDataTableService constructor.
     */
    public function __construct()
    {
        $this->model = app()->make('InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract');
    }

    /**
     * Запрос на получение данных таблицы.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Exception
     */
    public function ajax()
    {
        $transformer = app()->make('InetStudio\Classifiers\Groups\Contracts\Transformers\Back\GroupTransformerContract');

        return DataTables::of($this->query())
            ->setTransformer($transformer)
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->model->buildQuery([
            'columns' => ['created_at', 'updated_at']
        ]);

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): Builder
    {
        $table = app('datatables.html');

        return $table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Название'],
            ['data' => 'alias', 'name' => 'alias', 'title' => 'Алиас'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            ['data' => 'actions', 'name' => 'actions', 'title' => 'Действия', 'orderable' => false, 'searchable' => false],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.classifiers.groups.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $i18n = trans('admin::datatables');

        return [
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $i18n,
        ];
    }
}