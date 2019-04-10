<?php

namespace InetStudio\Classifiers\Groups\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Classifiers\Groups\Contracts\Http\Responses\Back\Resource\IndexResponseContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract, Responsable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * IndexResponse constructor.
     *
     * @param  array  $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function toResponse($request)
    {
        return view('admin.module.classifiers.groups::back.pages.index', $this->data);
    }
}
