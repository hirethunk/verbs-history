<?php

namespace Thunk\VerbsCommands;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Thunk\Verbs\Support\PendingEvent;
use Thunk\VerbsCommands\Livewire\SupportVerbsCommands;

class VerbsCommandsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('verbs-commands')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        require_once __DIR__.'/Support/helpers.php';
    }

    public function packageRegistered()
    {
        //
    }

    public function boot()
    {
        parent::boot();

        PendingEvent::macro('hasAllRequiredParams', function () {
            return true;
        });

        app()->singleton(VerbsCommandRegistry::class);

        if ($this->app->has('livewire')) {
            $manager = $this->app->make('livewire');

            // Component hooks only exist in v3, so we need to check before registering our hook
            if (method_exists($manager, 'componentHook')) {
                $manager->componentHook(SupportVerbsCommands::class);
            }
        }
    }
}
