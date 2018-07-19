<?php

namespace Iankov\ControlPanelNews;

use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'icp-news');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/iankov/control-panel-news'),
        ], 'icp_news_views');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'icp_news_migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/helpers.php';

        $config = require __DIR__ . '/config.php';
        $icp = $this->app['config']->get('icp', []);
        $this->app['config']->set('icp', array_replace_recursive($config, $icp));
    }
}
