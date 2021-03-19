<?php

namespace Kodewbit\Booklets;

use Illuminate\Support\ServiceProvider;
use Kodewbit\Booklets\Contracts\InternetArchive;
use Kodewbit\Booklets\Contracts\LibriVox;
use Kodewbit\Booklets\Services\InternetArchiveService;
use Kodewbit\Booklets\Services\LibriVoxService;

class BookletsServiceProvider extends ServiceProvider
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
        $this->app->bind(InternetArchive::class, InternetArchiveService::class);
        $this->app->bind(LibriVox::class, LibriVoxService::class);
    }
}
