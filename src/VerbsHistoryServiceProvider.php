<?php

namespace Thunk\VerbsHistory;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class VerbsHistoryServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('verbs-history')
            ->hasConfigFile();
    }

    public function registeringPackage()
    {
        // require_once __DIR__.'/Support/helpers.php';
    }

    public function packageRegistered()
    {
        //
    }

    public function boot()
    {
        parent::boot();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'verbs');
    }
}
