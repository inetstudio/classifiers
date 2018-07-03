@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Редактирование классификатора' : 'Добавление классификатора';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.classifiers::back.partials.breadcrumbs.form')
    @endpush

    <div class="row m-sm">
        <a class="btn btn-white" href="{{ route('back.classifiers.index') }}">
            <i class="fa fa-arrow-left"></i> Вернуться назад
        </a>
    </div>

    <div class="wrapper wrapper-content">

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.classifiers.store') : route('back.classifiers.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('classifier_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

            {!! Form::hidden('classifier_type', get_class($item), ['id' => 'object-type']) !!}

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    {!! Form::dropdown('type', $item->type, [
                                        'label' => [
                                            'title' => 'Тип',
                                        ],
                                        'field' => [
                                            'class' => 'select2 form-control',
                                            'data-placeholder' => 'Выберите тип',
                                            'data-create' => '1',
                                            'style' => 'width: 100%',
                                            'data-source' => route('back.classifiers.getSuggestions', ['type' => '']),
                                        ],
                                        'options' => [
                                            'values' => (old('type')) ? \InetStudio\Classifiers\Models\ClassifierModel::where('type', old('type'))->pluck('type', 'type')->toArray() : ['id' => $item->type, 'text' => $item->type],
                                        ],
                                    ]) !!}

                                    {!! Form::string('value', $item->value, [
                                        'label' => [
                                            'title' => 'Значение',
                                        ],
                                    ]) !!}

                                    {!! Form::string('alias', $item->alias, [
                                        'label' => [
                                            'title' => 'Алиас',
                                        ],
                                    ]) !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::buttons('', '', ['back' => 'back.classifiers.index']) !!}

        {!! Form::close()!!}
    </div>
@endsection
