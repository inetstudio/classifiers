@php
    $item = $value;
@endphp

{!! Form::dropdown('classifiers[]', $item->classifiers()->where('type', $attributes['field']['type'])->pluck('classifiers.id')->toArray(), [
    'label' => [
        'title' => $attributes['label']['title'],
    ],
    'field' => [
        'class' => 'select2 form-control',
        'data-placeholder' => $attributes['field']['placeholder'],
        'style' => 'width: 100%',
        'multiple' => 'multiple',
        'data-source' => route('back.classifiers.getSuggestions', ['type' => $attributes['field']['type']]),
    ],
    'options' => [
        'values' => (old('classifiers')) ? \InetStudio\Classifiers\Models\ClassifierModel::whereIn('id', old('classifiers'))->where('type', $attributes['field']['type'])->pluck('classifiers.value', 'classifiers.id')->toArray() : $item->classifiers()->where('type', $attributes['field']['type'])->pluck('classifiers.value', 'classifiers.id')->toArray(),
    ],
]) !!}
