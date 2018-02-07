<?php

namespace InetStudio\Classifiers\Http\Requests\Back;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SaveClassifierRequest
 * @package InetStudio\Classifiers\Http\Requests\Back
 */
class SaveClassifierRequest extends FormRequest
{
    /**
     * Определить, авторизован ли пользователь для этого запроса.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Сообщения об ошибках.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'type.required' => 'Поле «Тип» обязательно для заполнения',
            'type.max' => 'Поле «Тип» не должно превышать 255 символов',
            'value.required' => 'Поле «Значение» обязательно для заполнения',
            'value.max' => 'Поле «Значение» не должно превышать 255 символов',
            'value.unique' => 'Такое значение поля «Значение» уже существует',
            'alias.max' => 'Поле «Алиас» не должно превышать 255 символов',
            'alias.unique' => 'Такое значение поля «Алиас» уже существует',
        ];
    }

    /**
     * Правила проверки запроса.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        return [
            'type' => 'required|max:255',
            'value' => [
                'required',
                'max:255',
                Rule::unique('classifiers', 'value')->ignore($request->get('classifier_id'))->where(function ($query) use ($request) {
                    $query->where('type', $request->get('type'));
                }),
            ],
            'alias' => 'max:255|unique:classifiers,alias,'.$request->get('classifier_id'),
        ];
    }
}
