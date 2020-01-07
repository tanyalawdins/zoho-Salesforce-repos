<?php

namespace Asciisd\Zoho\Providers;

use Asciisd\Zoho\Console\Commands\InstallCommand;
use Asciisd\Zoho\Console\Commands\SetupCommand;
use Asciisd\Zoho\RestClient;
use Illuminate\Support\ServiceProvider;

class ZohoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Config
         *
         * Uncomment this function call to make the config file publishable using the 'config' tag.
         */
        $this->publishes([
            __DIR__ . '/../../config/zoho.php' => config_path('zoho.php'),
        ], 'zoho-config');

        $this->publishes([
            __DIR__ . '/Storage/oauth' => storage_path('app/zoho/oauth'),
        ], 'zoho-oauth');

        /**
         * Routes
         *
         * Uncomment this function call to load the route files.
         * A web.php file has already been generated.
         */
        // $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

        /**
         * Translations
         *
         * Uncomment the first function call to load the translations.
         * Uncomment the second function call to load the JSON translations.
         * Uncomment the third function call to make the translations publishable using the 'translations' tag.
         */
        // $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'zoho');
        // $this->loadJsonTranslationsFrom(__DIR__.'/../../resources/lang', 'zoho');
        // $this->publishes([
        //     __DIR__.'/../../resources/lang' => resource_path('lang/vendor/zoho'),
        // ], 'translations');

        /**
         * Views
         *
         * Uncomment the first section to load the views.
         * Uncomment the second section to make the view publishable using the 'view' tags.
         */
        // $this->loadViewsFrom(__DIR__.'/../../resources/views', 'zoho');
        // $this->publishes([
        //     __DIR__.'/../../resources/views' => resource_path('views/vendor/zoho'),
        // ], 'views');

        /**
         * Commands
         *
         * Uncomment this section to load the commands.
         * A basic command file has already been generated in 'src\Console\Commands\MyPackageCommand.php'.
         */
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                SetupCommand::class,
            ]);
        }

        /**
         * Public assets
         *
         * Uncomment this functin call to make the public assets publishable using the 'public' tag.
         */
        // $this->publishes([
        //     __DIR__.'/../../public' => public_path('vendor/zoho'),
        // ], 'public');

        /**
         * Migrations
         *
         * Uncomment the first function call to load the migrations.
         * Uncomment the second function call to make the migrations publishable using the 'migrations' tags.
         */
        // $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        // $this->publishes([
        //     __DIR__.'/../../database/migrations/' => database_path('migrations')
        // ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Config file
         *
         * Uncomment this function call to load the config file.
         * If the config file is also publishable, it will merge with that file
         */
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/zoho.php', 'zoho'
        );

        $this->app->singleton(RestClient::class, function ($app) {
            $configuration = [
                'client_id' => config('zoho.client_id'),
                'client_secret' => config('zoho.client_secret'),
                'redirect_uri' => config('zoho.redirect_uri'),
                'currentUserEmail' => config('zoho.current_user_email'),
                'applicationLogFilePath' => config('zoho.application_log_file_path'),
                'token_persistence_path' => config('zoho.token_persistence_path'),
                'accounts_url' => config('zoho.accounts_url'),
                'sandbox' => config('zoho.sandbox'),
                'apiBaseUrl' => config('zoho.api_base_url'),
                'apiVersion' => config('zoho.api_version'),
                'access_type' => config('zoho.access_type'),
                'persistence_handler_class' => config('zoho.persistence_handler_class'),
            ];

            return new RestClient($configuration);
        });
    }
}