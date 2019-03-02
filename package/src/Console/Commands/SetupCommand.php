<?php

namespace InetStudio\Classifiers\Console\Commands;

use InetStudio\AdminPanel\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:classifiers:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup classifiers package';

    /**
     * Инициализация команд.
     *
     * @return void
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'inetstudio:classifiers:groups:setup',
            ],
            [
                'type' => 'artisan',
                'description' => '',
                'command' => 'inetstudio:classifiers:entries:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Publish migrations',
                'command' => 'vendor:publish',
                'params' => [
                    '--provider' => 'InetStudio\Classifiers\Providers\ClassifiersServiceProvider',
                    '--tag' => 'migrations',
                ],
            ],
            [
                'type' => 'artisan',
                'description' => 'Migration',
                'command' => 'migrate',
            ],
        ];
    }
}
