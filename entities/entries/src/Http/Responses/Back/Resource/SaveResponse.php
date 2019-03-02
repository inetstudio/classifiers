<?php

namespace InetStudio\Classifiers\Entries\Http\Responses\Back\Resource;

use Illuminate\Http\RedirectResponse;
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
     * @param EntryModelContract $item
     */
    public function __construct(EntryModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        return response()->redirectToRoute('back.classifiers.entries.edit', [
            $this->item->fresh()->id,
        ]);
    }
}
