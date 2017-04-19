<?php namespace Sugeng\Soap;

use Illuminate\Support\ServiceProvider;

/**
 * Created By: Sugeng
 * Date: 1/24/17
 * Time: 09:24
 */
class SoapClientServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/forlap.php' => config_path('forlap.php')
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/forlap.php', 'soap');

        $this->app->singleton('soap.client', function () {
            return new Client(config('soap'));
        });
    }

    public function provides()
    {
        return ['soap.client', 'Sugeng\Soap\Client'];
    }
}