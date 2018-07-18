@php
    $item = $value;

    $values = $item->classifiers()->where('type', $attributes['field']['type'])->pluck('classifiers.value', 'classifiers.id')->toArray();

    if (empty($values) && isset($attributes['field']['default'])) {
        $values = \InetStudio\Classifiers\Models\ClassifierModel::whereIn('alias', (array) $attributes['field']['default'])
            ->pluck('classifiers.value', 'classifiers.id')
            ->toArray();
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
        'data-source' => route('back.classifiers.getSuggestions', ['type' => $attributes['field']['type']]),
    ], ((! isset($attributes['field']['multiple'])) || isset($attributes['field']['multiple']) && $attributes['field']['multiple']) ? ['multiple' => 'multiple'] : [],
       (isset($attributes['field']['readonly']) && $attributes['field']['readonly']) ? ['readonly' => 'readonly'] : []
    ),
    'options' => [
        'values' => (old('classifiers')) ? \InetStudio\Classifiers\Models\ClassifierModel::whereIn('id', old('classifiers'))->where('type', $attributes['field']['type'])->pluck('classifiers.value', 'classifiers.id')->toArray() : $values,
    ],
]) !!}
