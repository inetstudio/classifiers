<?php

namespace InetStudio\Classifiers\Http\Controllers\Back;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use InetStudio\Classifiers\Models\ClassifierModel;
use InetStudio\Classifiers\Transformers\ClassifierTransformer;
use InetStudio\Classifiers\Http\Requests\Back\SaveClassifierRequest;
use InetStudio\AdminPanel\Http\Controllers\Back\Traits\DatatablesTrait;

/**
 * Контроллер для управления классификаторами.
 *
 * Class ContestByTagclassifiersController
 */
class ClassifiersController extends Controller
{
    use DatatablesTrait;

    /**
     * Список классификаторов.
     *
     * @param DataTables $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(DataTables $dataTable)
    {
        $table = $this->generateTable($dataTable, 'classifiers', 'index');

        return view('admin.module.classifiers::pages.index', compact('table'));
    }

    /**
     * DataTables serverside.
     *
     * @return mixed
     */
    public function data()
    {
        $items = ClassifierModel::query();

        return Datatables::of($items)
            ->setTransformer(new ClassifierTransformer)
            ->escapeColumns(['actions'])
            ->make();
    }

    /**
     * Добавление классификатора.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.module.classifiers::pages.form', [
            'item' => new ClassifierModel(),
        ]);
    }

    /**
     * Создание классификатора.
     *
     * @param SaveClassifierRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SaveClassifierRequest $request)
    {
        return $this->save($request);
    }

    /**
     * Редактирование классификатора.
     *
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id = null)
    {
        if (! is_null($id) && $id > 0 && $item = ClassifierModel::find($id)) {

            return view('admin.module.classifiers::pages.form', [
                'item' => $item,
            ]);
        } else {
            abort(404);
        }
    }

    /**
     * Обновление классификатора.
     *
     * @param SaveClassifierRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SaveClassifierRequest $request, $id = null)
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение классификатора.
     *
     * @param SaveClassifierRequest $request
     * @param null $id
     * @return \Illuminate\Http\RedirectResponse
     */
    private function save($request, $id = null)
    {
        if (! is_null($id) && $id > 0 && $item = ClassifierModel::find($id)) {
            $action = 'отредактирован';
        } else {
            $action = 'создан';
            $item = new ClassifierModel();
        }

        $item->type = strip_tags($request->get('type'));
        $item->value = strip_tags($request->get('value'));
        $item->save();

        Session::flash('success', 'Классификатор «'.$item->type.' / '.$item->value.'» успешно '.$action);

        return redirect()->to(route('back.classifiers.edit', $item->fresh()->id));
    }

    /**
     * Удаление классификатора.
     *
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id = null)
    {
        if (! is_null($id) && $id > 0 && $item = ClassifierModel::find($id)) {
            $item->delete();

            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    /**
     * Возвращаем значения для поля.
     *
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuggestions(Request $request, $type = '')
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
