<?php namespace Marabooyankee\Inception\Commands;


use Doctrine\CouchDB\CouchDBClient;
use Doctrine\CouchDB\View\FolderDesignDocument;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use Marabooyankee\Inception\Design\CouchViews;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 6:17 PM
 *
 */
class SetupInception extends Command
{

    /**
     * @var CouchDBClient
     */
    protected $couchClient;
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inception:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the database and the views for indexing.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->couchClient = app('inception:cloudant-client');

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        /**@var Client $elasticClient */
        $elasticClient = app('inception:elastic-client');
        $mappings = array(
            'csv' => [
                "properties" => [
                    'geometry' => [

                        'type' => 'geo_shape',
                        "tree" => 'quadtree',
                        'precision' => '1m'


                    ]
                ]
            ]

        );

        $index = [
            'index' => 'csv_dump',
            'body' => [
                'mappings' => $mappings

            ]
        ];

        $elasticClient->indices()->delete(['index' => 'csv_dump']);

        $elasticClient->indices()->create($index);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
