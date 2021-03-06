<?php

namespace InetStudio\Classifiers\Groups\Transformers\Back\Utility;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Transformers\Back\Utility\SuggestionTransformerContract;

/**
 * Class SuggestionTransformer.
 */
class SuggestionTransformer extends TransformerAbstract implements SuggestionTransformerContract
{
    /**
     * @var string
     */
    protected $type;

    /**
     * SuggestionTransformer constructor.
     *
     * @param  string  $type
     */
    public function __construct(string $type = '')
    {
        $this->type = $type;
    }

    /**
     * Подготовка данных для отображения в выпадающих списках.
     *
     * @param  GroupModelContract  $item
     *
     * @return array
     */
    public function transform(GroupModelContract $item): array
    {
        $itemData = [
            'id' => $item['id'],
            'name' => $item['name'],
        ];

        return ($this->type == 'autocomplete')
            ? [
                'value' => $item['name'],
                'data' => $itemData,
            ]
            : $itemData;
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}
