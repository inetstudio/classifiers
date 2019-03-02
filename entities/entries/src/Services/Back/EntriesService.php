<?php

namespace InetStudio\Classifiers\Entries\Services\Back;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Session;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\AdminPanel\Base\Services\Back\BaseService;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract;

/**
 * Class EntriesService.
 */
class EntriesService extends BaseService implements EntriesServiceContract
{
    /**
     * EntriesService constructor.
     */
    public function __construct()
    {
        parent::__construct(app()->make('InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract'));
    }

    /**
     * Сохраняем модель.
     *
     * @param array $data
     * @param int $id
     *
     * @return EntryModelContract
     */
    public function save(array $data, int $id): EntryModelContract
    {
        $groupsService = app()->make('InetStudio\Classifiers\Groups\Contracts\Services\Back\GroupsServiceContract');

        $action = ($id) ? 'отредактирована' : 'создана';

        $item = $this->saveModel($data, $id);

        $groupsService->attachToObject($data['groups'], $item);

        event(app()->makeWith('InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyEntryEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Запись успешно '.$action);

        return $item;
    }

    /**
     * Возвращаем подсказки.
     *
     * @param string $search
     * @param $type
     * @param string $group
     *
     * @return array
     */
    public function getSuggestions(string $search, $type, string $group): array
    {
        if ($group == '') {
            $items = $this->model::where([['value', 'LIKE', '%' . $search . '%']])->get();
        } else {
            $items = $this->model::where([['value', 'LIKE', '%' . $search . '%']])
                ->whereHas('groups', function ($query) use ($group) {
                    $query->where('name', '=', $group)->orWhere('alias', '=', $group);
                })
                ->get();
        }

        $resource = (app()->makeWith('InetStudio\Classifiers\Entries\Contracts\Transformers\Back\SuggestionTransformerContract', [
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
     * Присваиваем классификаторы объекту.
     *
     * @param $request
     *
     * @param $item
     */
    public function attachToObject($request, $item)
    {
        if ($request->filled('classifiers')) {
            $item->syncClassifiers($this->model::whereIn('id', (array) $request->get('classifiers'))->get());
        } else {
            $item->detachClassifiers($item->classifiers);
        }
    }

    /**
     * Возвращаем значения классификаторов объекта по группе.
     *
     * @param $item
     * @param string $group
     *
     * @return array
     */
    public function getItemEntriesByGroup($item, string $group): array
    {
        $values = $item->classifiers()->whereHas('groups', function ($query) use ($group) {
            $query->where('name', '=', $group)->orWhere('alias', '=', $group);
        })->pluck('classifiers_entries.value', 'classifiers_entries.id')->toArray();

        return $values;
    }

    /**
     * Возвращаем значения классификаторов для выпадающего списка по массиву алиасов.
     *
     * @param $aliases
     *
     * @return array
     */
    public function getEntriesValuesByAliases($aliases): array
    {
        $values = $this->model::whereIn('alias', (array) $aliases)
            ->pluck('classifiers_entries.value', 'classifiers_entries.id')
            ->toArray();

        return $values;
    }

    /**
     * Возвращаем значения классификаторов для выпадающего списка по массиву id и группе.
     *
     * @param $ids
     * @param string $group
     *
     * @return array
     */
    public function getEntriesValuesByIDsAndGroup($ids, string $group): array
    {
        $values = $this->model::whereIn('id', (array) $ids)
            ->whereHas('groups', function ($query) use ($group) {
                $query->where('name', '=', $group)->orWhere('alias', '=', $group);
            })
            ->pluck('classifiers_entries.value', 'classifiers_entries.id')
            ->toArray();

        return $values;
    }
}
