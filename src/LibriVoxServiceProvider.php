<?php

namespace Kodewbit\LibriVox;

use Illuminate\Support\ServiceProvider;
use Kodewbit\LibriVox\Contracts\LibriVox as LibriVoxInterface;

class LibriVoxServiceProvider extends ServiceProvider
{
    /**
     * @inheritdoc
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureBindings();
    }

    /**
     * Register the package's bindings.
     *
     * @return void
     */
    private function configureBindings()
    {
        $this->app->bind(LibriVoxInterface::class, LibriVox::class);
    }
}
