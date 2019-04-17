<?php

namespace InetStudio\Classifiers\Groups\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\Classifiers\Groups\Contracts\Models\GroupModelContract;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract
{
    /**
     * @var GroupModelContract
     */
    protected $item;

    /**
     * SaveResponse constructor.
     *
     * @param  GroupModelContract  $item
     */
    public function __construct(GroupModelContract $item)
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
        $item = $this->item->fresh();

        return response()->redirectToRoute(
            'back.classifiers.groups.edit',
            [
                $item['id'],
            ]
        );
    }
}
