<?php


namespace LarawireGarage\LarawireModals;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use LarawireGarage\LarawireModals\LarawireModalBladeDirectives;
use LarawireGarage\LarawireModals\Console\Commands\MakeLivewireModalCommand;
use LarawireGarage\LarawireModals\Views\Components\Modal;

class LarawireModalsServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }
    public function boot()
    {
        $this->registerViews();
        $this->registerComponents();
        $this->registerDirectives();

        $this->mergeConfigFrom(__DIR__ . '/../configs/larawire-modals.php', 'larawire-modals');
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->publishResources();
        }
    }
    public function registerCommands()
    {
        $this->commands([
            MakeLivewireModalCommand::class
        ]);
    }
    public function publishResources()
    {
        // $this->publishes([__DIR__ . '/../resources/js/build' => public_path('vendor/larawire/modals')], 'larawire-modals-assets'); // Publish assets
        $this->publishes([__DIR__ . '/../configs/larawire-modals.php' => config_path('larawire-modals.php')], 'larawire-modals-configs'); // publish configs
    }
    public function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views/components', 'larawire');

        if (!$this->app->runningInConsole())
            return;

        // $this->publishes([
        //     __DIR__ . '/../resources/views/components' => resource_path('views/vendor/larawire/modals'),
        // ], 'larawire-modals-assets');
    }
    public function registerComponents()
    {
        Blade::componentNamespace('LarawireGarage\\LarawireModals\\Views\\Components', 'larawire');
    }
    public function registerDirectives()
    {
        Blade::directive('larawireModalScripts', [LarawireModalBladeDirectives::class, 'larawireModalScripts']);
    }
}