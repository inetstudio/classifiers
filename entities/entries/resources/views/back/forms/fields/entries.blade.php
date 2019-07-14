@inject('entriesService', 'InetStudio\Classifiers\Entries\Contracts\Services\Back\ItemsServiceContract')

@php
    $item = $value;

    $values = $entriesService->getItemEntriesByGroup($item, $attributes['field']['group']);

    if ($values->count() == 0 && isset($attributes['field']['default'])) {
        $values = $entriesService->getEntriesByAliases($attributes['field']['default']);
    }

    $values = $values->pluck('value', 'id')->toArray();
@endphp

{!! Form::dropdown('classifiers[]', array_keys($values), [
    'label' => [
        'title' => $attributes['label']['title'],
    ],
    'field' => array_merge([
        'id' => 'classifiers_'.md5($attributes['field']['group']),
        'class' => 'select2-drop form-control',
        'data-placeholder' => $attributes['field']['placeholder'],
        'style' => 'width: 100%',
        'data-source' => route('back.classifiers.entries.getSuggestions', ['group' => $attributes['field']['group']]),
    ], ((! isset($attributes['field']['multiple'])) || isset($attributes['field']['multiple']) && $attributes['field']['multiple']) ? ['multiple' => 'multiple'] : [],
       (isset($attributes['field']['readonly']) && $attributes['field']['readonly']) ? ['readonly' => 'readonly'] : []
    ),
    'options' => [
        'values' => (old('classifiers')) ? $entriesService->getEntriesByIdsAndGroup(old('classifiers'), $attributes['field']['group'])->pluck('value', 'id')->toArray() : $values,
    ],
]) !!}
