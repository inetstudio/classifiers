<?php

namespace InetStudio\Classifiers\Providers;

use Collective\Html\FormBuilder;
use Illuminate\Support\ServiceProvider;

/**
 * Class FormBuilderServiceProvider.
 */
class FormBuilderServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        FormBuilder::component('classifiers', 'admin.module.classifiers::back.forms.fields.classifiers', ['name' => null, 'value' => null, 'attributes' => null]);
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
    }
}
