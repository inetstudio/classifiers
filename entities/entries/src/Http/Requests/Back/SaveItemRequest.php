<?php

namespace InetStudio\Classifiers\Entries\Http\Requests\Back;

use Illuminate\Foundation\Http\FormRequest;
use InetStudio\Classifiers\Entries\Contracts\Http\Requests\Back\SaveItemRequestContract;

/**
 * Class SaveItemRequest.
 */
class SaveItemRequest extends FormRequest implements SaveItemRequestContract
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
            'groups.required' => 'Поле «Группы» обязательно для заполнения',
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'groups' => 'required',
            'value' => [
                'required',
                'max:255',
                /*Rule::unique('classifiers', 'value')->ignore($request->get('entry_id'))->where(function ($query) use ($request) {
                    $query->where('group', $request->get('group'));
                }),*/
            ],
            'alias' => 'max:255|unique:classifiers_entries,alias,'.$this->get('entry_id'),
        ];
    }
}
