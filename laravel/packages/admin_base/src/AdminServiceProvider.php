<?php
namespace Marol;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->mergeConfigFrom(
            __DIR__.'/../config/cors.php', 'cors'
        );

        var_dump(config('cors'));
    }
}