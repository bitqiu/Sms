<?php
namespace ULan\Sms\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class SmsManagerServiceProvider extends ServiceProvider
{
    /**
     * bootstrap, add routes
     */
    public function boot()
    {
        //publish a config file
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('sms.php')
        ], 'config');

        //publish migrations
        $this->publishes([
            __DIR__ . '/../../migrations/' => database_path('/migrations')
        ], 'migrations');

        //route file
        require __DIR__ . '/../routes.php';

        //validations file
        require __DIR__ . '/../validations.php';
    }

    /**
     * register the service provider
     */
    public function register()
    {
        // Merge configs
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'sms'
        );

        $this->app->singleton('SmsManager', function(){
            return new SmsManager($this->app);
        });
    }

    public function provides()
    {
        return array('SmsManager');
    }
}