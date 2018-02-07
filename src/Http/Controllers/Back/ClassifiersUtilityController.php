<?php

namespace InetStudio\Classifiers\Http\Controllers\Back;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use InetStudio\Classifiers\Models\ClassifierModel;

/**
 * Class ClassifiersUtilityController
 * @package InetStudio\Classifiers\Http\Controllers\Back
 */
class ClassifiersUtilityController extends Controller
{
    /**
     * Возвращаем значения для поля.
     *
     * @param Request $request
     * @param $type
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuggestions(Request $request, $type = ''): JsonResponse
    {
        $search = $request->get('q');
        $data = [];

        if ($type == '') {
            $types = ClassifierModel::select(['type'])
                ->where('type', 'LIKE', '%'.$search.'%')
                ->groupBy('type')
                ->get();

            $data['items'] = $types->map(function ($item) {
                return [
                    'id' => $item->type,
                    'name' => $item->type,
                ];
            })->toArray();
        } else {
            $types = ClassifierModel::select(['id', 'type', 'value'])
                ->where('type', $type)
                ->where('value', 'LIKE', '%'.$search.'%')
                ->get();

            $data['items'] = $types->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->value,
                ];
            })->toArray();
        }

        return response()->json($data);
    }
}
