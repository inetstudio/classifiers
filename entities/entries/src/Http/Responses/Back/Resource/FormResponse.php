<?php

namespace InetStudio\Classifiers\Entries\Http\Responses\Back\Resource;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Classifiers\Entries\Contracts\Http\Responses\Back\Resource\FormResponseContract;

/**
 * Class FormResponse.
 */
class FormResponse implements FormResponseContract, Responsable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * FormResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии формы объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.classifiers.entries::back.pages.form', $this->data);
    }
}
