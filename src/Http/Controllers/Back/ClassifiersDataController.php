<?php

namespace InetStudio\Classifiers\Http\Controllers\Back;

use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Models\ClassifierModel;
use InetStudio\Classifiers\Transformers\Back\ClassifierTransformer;

/**
 * Class ClassifiersDataController.
 */
class ClassifiersDataController extends Controller
{
    /**
     * DataTables ServerSide.
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function data()
    {
        $items = ClassifierModel::query();

        return DataTables::of($items)
            ->setTransformer(new ClassifierTransformer)
            ->escapeColumns(['actions'])
            ->make();
    }
}
