@inject('groupsService', 'InetStudio\Classifiers\Groups\Contracts\Services\Back\ItemsServiceContract')

@php
    $item = $value;
@endphp

{!! Form::dropdown('groups[]', $item->groups()->pluck('id')->toArray(), [
    'label' => [
        'title' => 'Группы',
    ],
    'field' => [
        'class' => 'select2-drop form-control',
        'data-placeholder' => 'Выберите группы',
        'style' => 'width: 100%',
        'multiple' => 'multiple',
        'data-source' => route('back.classifiers.groups.getSuggestions'),
        'data-exclude' => isset($attributes['exclude']) ? implode('|', $attributes['exclude']) : '',
    ],
    'options' => [
        'values' => (old('groups')) ? $groupsService->getItemById(old('groups'))->pluck('name', 'id')->toArray() : $item->groups()->pluck('name', 'id')->toArray(),
    ],
]) !!}
