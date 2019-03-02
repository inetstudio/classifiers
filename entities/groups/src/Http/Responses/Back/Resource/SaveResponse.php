<?php

namespace InetStudio\Classifiers\Groups\Http\Responses\Back\Resource;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var GroupModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param GroupModelContract $item
     */
    public function __construct(GroupModelContract $item)
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
        return response()->redirectToRoute('back.classifiers.groups.edit', [
            $this->item->fresh()->id,
        ]);
    }
}
