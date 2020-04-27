<?php

namespace Shahnewaz\CodeCanyonLicensor\Providers;

use Illuminate\Support\ServiceProvider;
use Shahnewaz\CodeCanyonLicensor\Services\LicenseService;

class LicenseServiceProvider extends ServiceProvider
{
    /** 
    * This provider cannot be deferred since it loads routes.
    * If deferred, run `php artisan route:cache`
    **/
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->load();
        $this->publish();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->packagePath('config/license.php'), 'license');

        $this->app['router']->aliasMiddleware('licensed', \Shahnewaz\CodeCanyonLicensor\Http\Middleware\License::class);
        
        $this->app->singleton('licensor', function ($app) {
            return new LicenseService;
        });
    }

    public function provides () {
        return ['licensor'];
    }

    // Root path for package files
    private function packagePath($path) {
        return __DIR__."/../../$path";
    }


    // Class loaders for package
    private function load () {
        // Routes
        $this->loadRoutesFrom($this->packagePath('src/routes/web.php'));
        // Views
        $this->loadViewsFrom($this->packagePath('resources/views'), 'licensor');
        // Translations
        $this->loadTranslationsFrom($this->packagePath('resources/lang'), 'licensor');
    }

    // Publish required resouces from package
    private function publish () {

        // Publish Translations
        $this->publishes([
            $this->packagePath('resources/lang') => resource_path('lang/vendor'),
        ], 'translations');
        
        // Publish License Config
        $this->publishes([
            $this->packagePath('config/license.php') => config_path('license.php'),
        ], 'license');

        // Publish assets
        $this->publishes([
            $this->packagePath('resources/assets') => public_path('vendor/licensor'),
        ], 'assets');

    }

}
