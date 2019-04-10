<?php

namespace InetStudio\Classifiers\Entries\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Classifiers\Entries\Contracts\Models\EntryModelContract;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var EntryModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  EntryModelContract  $item
     */
    public function __construct(EntryModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->redirectToRoute(
            'back.classifiers.entries.edit',
            [
                $this->item->fresh()->id,
            ]
        );
    }
}
