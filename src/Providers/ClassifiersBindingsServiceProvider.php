<?php

namespace InetStudio\Classifiers\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ClassifiersBindingsServiceProvider.
 */
class ClassifiersBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Classifiers\Contracts\Services\Back\ClassifiersServiceContract' => 'InetStudio\Classifiers\Services\Back\ClassifiersService',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
