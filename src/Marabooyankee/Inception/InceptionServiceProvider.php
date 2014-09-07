<?php namespace Marabooyankee\Inception;

use Illuminate\Support\ServiceProvider;
use Marabooyankee\Inception\Commands\DataImporter;
use Marabooyankee\Inception\Commands\SetupInception;

class InceptionServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->bind('inception:data-importer-command', function () {
            return new DataImporter();
        });

        $this->app->bind('inception:setup-command', function () {
            return new SetupInception();
        });


        $this->app->singleton('inception:cloudant-client', function () {
            return \Doctrine\CouchDB\CouchDBClient::create(\Config::get('inception::config'));

        });

        $this->app->singleton('inception:elastic-client', function () {
            return new \Elasticsearch\Client(\Config::get('inception::elasticsearch'));

        });

        $this->package('marabooyankee/inception');
        include __DIR__ . '/../../routes.php';


    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(array('inception:data-importer-command', 'inception:setup-command'));
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
