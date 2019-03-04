@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Просмотр группы' : 'Создание группы';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.classifiers.groups::back.partials.breadcrumbs.form')
    @endpush

    <div class="row m-sm">
        <a class="btn btn-white" href="{{ route('back.classifiers.groups.index') }}">
            <i class="fa fa-arrow-left"></i> Вернуться назад
        </a>
    </div>

    <div class="wrapper wrapper-content">

        {!! Form::info() !!}

        {!! Form::open(['url' => (! $item->id) ? route('back.classifiers.groups.store') : route('back.classifiers.groups.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif
    
            {!! Form::hidden('group_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}
    
            {!! Form::hidden('group_type', get_class($item), ['id' => 'object-type']) !!}
    
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
    
                                    {!! Form::string('name', $item->name, [
                                        'label' => [
                                            'title' => 'Название',
                                        ],
                                    ]) !!}
    
                                    {!! Form::string('alias', $item->alias, [
                                        'label' => [
                                            'title' => 'Алиас',
                                        ],
                                    ]) !!}

                                    {!! Form::wysiwyg('description', $item->description, [
                                        'label' => [
                                            'title' => 'Описание',
                                        ],
                                        'field' => [
                                            'class' => 'tinymce',
                                            'id' => 'description',
                                            'hasImages' => false,
                                        ],
                                    ]) !!}
    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            {!! Form::buttons('', '', ['back' => 'back.classifiers.groups.index']) !!}

        {!! Form::close()!!}

    </div>
@endsection