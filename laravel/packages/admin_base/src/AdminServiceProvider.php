<?php
namespace Marol;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class AdminServiceProvider extends ServiceProvider{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../configs/crm.php', 'crm'
        );

        $this->publishes([
            __DIR__.'/../database/seeders' => database_path('seeders'),
        ], 'marol_admin');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/crm.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Response::macro('return', function ($code='0' , $msg='' , $data=[]) {
            return Response::json(compact('code','msg','data'));
        });
    }
}