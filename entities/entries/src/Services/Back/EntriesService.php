<?php

namespace InetStudio\Classifiers\Entries\Services\Back;

use League\Fractal\Manager;
use Illuminate\Support\Facades\Session;
use League\Fractal\Serializer\DataArraySerializer;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract;
use InetStudio\Classifiers\Entries\Services\EntriesService as CommonEntriesService;

/**
 * Class EntriesService.
 */
class EntriesService extends CommonEntriesService implements EntriesServiceContract
{
    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return EntryModelContract
     */
    public function save(array $data, int $id): EntryModelContract
    {
        $groupsService = app()->make('InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract');

        $action = ($id) ? 'отредактирована' : 'создана';

        $item = $this->saveModel($data, $id);

        $groupsService->attachToObject($data['groups'], $item);

        event(
            app()->makeWith(
                'InetStudio\Classifiers\Entries\Contracts\Events\Back\ModifyEntryEventContract', [
                'object' => $item,
            ]
            )
        );

        Session::flash('success', 'Запись успешно '.$action);

        return $item;
    }

    /**
     * Возвращаем подсказки.
     *
     * @param  string  $search
     * @param $type
     * @param  string  $group
     *
     * @return array
     */
    public function getSuggestions(string $search, $type, string $group): array
    {
        if ($group == '') {
            $items = $this->model::where([['value', 'LIKE', '%'.$search.'%']])->get();
        } else {
            $items = $this->model::where([['value', 'LIKE', '%'.$search.'%']])
                ->whereHas(
                    'groups', function ($query) use ($group) {
                    $query->where('name', '=', $group)->orWhere('alias', '=', $group);
                }
                )
                ->get();
        }

        $resource = (app()->makeWith(
            'InetStudio\Classifiers\Entries\Contracts\Transformers\Back\SuggestionTransformerContract', [
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
}
