<?php

namespace Themey99\CorrelativeNumber;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Themey99\CorrelativeNumber\Contracts\Sequence as SequenceContract;

class CorrelativeNumberServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Filesystem $filesystem): void
    {
        if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
            $this->publishes(
                [
                    __DIR__ . '/../config/correlative-number.php' => config_path('correlative-number.php'),
                ],
                'package-name-config'
            );

            $this->publishes([
                __DIR__ . '/../database/migrations/create_correlative_numbers_table.php.stub' => $this->getMigrationFileName($filesystem),
            ], 'migrations');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\RebootSequence::class
            ]);
        }

        $this->registerModelBindings();
    }

    protected function registerModelBindings()
    {
        $configModel = $this->app->config['correlative-number.model'];

        if (!$configModel) {
            return;
        }

        $this->app->bind(SequenceContract::class, $configModel);
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path . '*_create_correlative_numbers_table.php');
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_create_correlative_numbers_table.php")
            ->first();
    }
}
