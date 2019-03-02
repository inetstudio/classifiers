<?php

namespace InetStudio\Classifiers\Groups\Services\Back;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Session;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract;

/**
 * Class GroupsService.
 */
class GroupsService extends BaseService implements GroupsServiceContract
{
    /**
     * GroupsService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return GroupModelContract
     */
    public function save(array $data, int $id): GroupModelContract
    {
        $action = ($id) ? 'отредактирована' : 'создана';

        $item = $this->saveModel($data, $id);

        event(app()->makeWith('InetStudio\Classifiers\Groups\Contracts\Events\Back\ModifyGroupEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Группа «'.$item->name.'» успешно '.$action);

        return $item;
    }

    /**
     * Получаем подсказки.
     *
     * @param string $search
     * @param $type
     *
     * @return array
     */
    public function getSuggestions(string $search, $type): array
    {
        $items = $this->model::where([['name', 'LIKE', '%'.$search.'%']])->get();

        $resource = (app()->makeWith('InetStudio\Classifiers\Groups\Contracts\Transformers\Back\SuggestionTransformerContract', [
            'type' => $type,
        ]))->transformCollection($items);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());

        $transformation = $manager->createData($resource)->toArray();

        if ($type && $type == 'autocomplete') {
            $data['suggestions'] = $transformation['data'];
        } else {
            $data['items'] = $transformation['data'];
        }

        return $data;
    }

    /**
     * Присваиваем группы объекту.
     *
     * @param $groups
     *
     * @param $item
     */
    public function attachToObject($groups, $item)
    {
        $groupsIDs = $groups ?? [];

        $item->groups()->sync($groupsIDs);
    }
}
