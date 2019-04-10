<?php

namespace InetStudio\Classifiers\Entries\Contracts\Transformers\Back\Utility;

use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;

/**
 * Interface SuggestionTransformerContract.
 */
interface SuggestionTransformerContract
{
    /**
     * Трансформация данных.
     *
     * @param  EntryModelContract  $item
     *
     * @return array
     */
    public function transform(EntryModelContract $item): array;

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection;
}
