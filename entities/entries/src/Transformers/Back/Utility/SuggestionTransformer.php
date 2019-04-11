<?php

namespace InetStudio\Classifiers\Entries\Transformers\Back\Utility;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Transformers\Back\Utility\SuggestionTransformerContract;

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
     * @param  EntryModelContract  $item
     *
     * @return array
     */
    public function transform(EntryModelContract $item): array
    {
        $itemData = [
            'id' => $item['id'],
            'name' => $item['value'],
        ];

        return ($this->type == 'autocomplete')
            ? [
                'value' => $item['value'],
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
