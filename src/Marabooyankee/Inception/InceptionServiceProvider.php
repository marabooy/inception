<?php namespace Marabooyankee\Inception;

use Elasticsearch\Client;
use Illuminate\Support\ServiceProvider;
use Marabooyankee\Inception\Commands\DataImporter;
use Marabooyankee\Inception\Commands\PhotosImporter;
use Marabooyankee\Inception\Commands\SetupInception;
use Marabooyankee\Inception\Commands\VideoMeta;

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
        $this->app->bind('inception:photo-importer-command', function () {
            return new PhotosImporter();
        });

        $this->app->bind('inception:video-importer-command', function () {
            return new VideoMeta();
        });


//        $this->app->singleton('inception:cloudant-client', function () {
//            return \Doctrine\CouchDB\CouchDBClient::create(\Config::get('inception::config'));
//
//        });

        $this->app->singleton('inception:elastic-client', function () {
            return new \Elasticsearch\Client(\Config::get('inception::elasticsearch'));

        });

        $this->app->bind('Elasticsearch\Client', function () {
            return app('inception:elastic-client');
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
        $this->commands(array('inception:data-importer-command', 'inception:photo-importer-command', 'inception:video-importer-command', 'inception:setup-command'));
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
