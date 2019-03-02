@inject('entriesService', 'InetStudio\Classifiers\Entries\Contracts\Services\Back\EntriesServiceContract')

@php
    $item = $value;

    $values = $entriesService->getItemEntriesByGroup($item, $attributes['field']['group']);

    if (empty($values) && isset($attributes['field']['default'])) {
        $values = $entriesService->getEntriesValuesByAliases($attributes['field']['default']);
    }
@endphp

{!! Form::dropdown('classifiers[]', array_keys($values), [
    'label' => [
        'title' => $attributes['label']['title'],
    ],
    'field' => array_merge([
        'class' => 'select2 form-control',
        'data-placeholder' => $attributes['field']['placeholder'],
        'style' => 'width: 100%',
        'data-source' => route('back.classifiers.entries.getSuggestions', ['group' => $attributes['field']['group']]),
    ], ((! isset($attributes['field']['multiple'])) || isset($attributes['field']['multiple']) && $attributes['field']['multiple']) ? ['multiple' => 'multiple'] : [],
       (isset($attributes['field']['readonly']) && $attributes['field']['readonly']) ? ['readonly' => 'readonly'] : []
    ),
    'options' => [
        'values' => (old('classifiers')) ? $entriesService->getEntriesValuesByIDsAndGroup(old('classifiers'), $attributes['field']['group']) : $values,
    ],
]) !!}
