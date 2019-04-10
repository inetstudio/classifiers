<?php

namespace InetStudio\Classifiers\Groups\Services\Back;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Session;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  GroupModelContract  $model
     */
    public function __construct(GroupModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return GroupModelContract
     */
    public function save(array $data, int $id): GroupModelContract
    {
        $action = ($id) ? 'отредактирована' : 'создана';

        $item = $this->saveModel($data, $id);

        event(
            app()->makeWith(
                'InetStudio\Classifiers\Groups\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Группа «'.$item->name.'» успешно '.$action);

        return $item;
    }

    /**
     * Получаем подсказки.
     *
     * @param  string  $search
     * @param $type
     *
     * @return array
     */
    public function getSuggestions(string $search, $type): array
    {
        $items = $this->model::where([['name', 'LIKE', '%'.$search.'%']])->get();

        $resource = (app()->makeWith(
            'InetStudio\Classifiers\Groups\Contracts\Transformers\Back\SuggestionTransformerContract', [
                                                                                                         'type' => $type,
                                                                                                     ]
        ))->transformCollection($items);

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
     * @param $groupsIds
     *
     * @param $item
     */
    public function attachToObject($groupsIds, $item)
    {
        $groupsIDs = $groupsIds ?? [];

        $item->groups()->sync($groupsIDs);
    }
}