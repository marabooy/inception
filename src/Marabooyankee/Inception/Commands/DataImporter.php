<?php namespace Marabooyankee\Inception\Commands;

use Doctrine\CouchDB\CouchDBClient;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Flysystem\File;
use Marabooyankee\Inception\Converters\Csv2GeoJson;
use Patchwork\Utf8;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/6/2014
 * Time: 1:19 PM
 */
class DataImporter extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inception:csv';

    protected $requiredFields = array('location latitude :', 'location longitude');

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a file to the .';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    private function cleanHeaders(array $headers)
    {

        $cleanHeaders = array();
        foreach ($headers as $header) {
//            $this->info($header);
            $bracketIndex = strpos($header, '(');
            if ($bracketIndex) {
                $cleanedHeader = substr($header, 0, $bracketIndex);
//                $this->info($cleanedHeader);
                array_push($cleanHeaders, trim(strtolower($cleanedHeader)));
            } else {
                array_push($cleanHeaders, trim(strtolower($header)));
            }


        }

        return $cleanHeaders;
    }

    private function  getIndex($columnName, $data)
    {


        return (array_search($columnName, $data));
    }

    public function saveToCloudant(array $data)
    {
        /**@var CouchDBClient $client */
        $client = app('inception:cloudant-client');
        $client->postDocument($data);

    }

    public function saveToElastic(array $data, $path)
    {
        /**@var Client $elasticClient */
        $elasticClient = app('inception:elastic-client');

        $request = array('body' => $data);
        $request['index'] = 'csv_dump';
        $request['type'] = 'csv';
        $elasticClient->index($request);

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $path = storage_path();
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path . '\data'), \RecursiveIteratorIterator::SELF_FIRST);
        /**@var \SplFileInfo $filePath */
        foreach ($iterator as $filePath) {
            if (!$filePath->isDir()) {
                if($filePath->getExtension()!=='csv')
                    continue;
                $csvreader = new Reader(new \SplFileObject($filePath->__toString()));
                $csvreader->setDelimiter(';');
                $headerRow = $csvreader->fetchOne(1);
//                print_r($this->cleanHeaders($headerRow));
                $headers = $this->cleanHeaders($headerRow);
                $latIndex = $this->getIndex('location latitude :', $headers);
                $lngIndex = $this->getIndex('location longitude :', $headers);
                $timestamp = $this->getIndex('yyyy-mo-dd hh-mi-ss_sss', $headers);
                $cumulativeTime = $this->getIndex('time since start in ms', $headers);
                $accelerometerX = $this->getIndex('accelerometer x', $headers);
                $accelerometerY = $this->getIndex('accelerometer y', $headers);
                $accelerometerZ = $this->getIndex('accelerometer z', $headers);
                $locationSpeed = $this->getIndex('location speed', $headers);
                $gyroscopeX = $this->getIndex('gyroscope x', $headers);
                $gyroscopeY = $this->getIndex('gyroscope y', $headers);
                $gyroscopeZ = $this->getIndex('gyroscope z', $headers);

                $locationIndexes = array($lngIndex, $latIndex);
                $propertyIndexes = array(
                    $timestamp,
                    $cumulativeTime,
                    $accelerometerX,
                    $accelerometerY,
                    $accelerometerZ,
                    $locationSpeed,
                    $gyroscopeX,
                    $gyroscopeY,
                    $gyroscopeZ
                );
                $propertyNames = array(
                    'timestamps',
                    'cumulative_time',
                    'accelerometer_x',
                    'accelerometer_y',
                    'accelerometer_z',
                    'speed',
                    'gyroscope_x',
                    'gyroscope_y',
                    'gyroscope_z',
                );
                \Log::debug('filename',[$filePath->__toString()]);
                \Log::debug('headers', $headerRow);
                \Log::debug('indexes', $propertyIndexes);
                \Log::debug('names', $propertyNames);
                $geoJson = new Csv2GeoJson($csvreader, $propertyIndexes, $propertyNames, $locationIndexes);

                $geoJson->convert();
                \Log::debug('csv', $geoJson->toArray());
                $this->saveToElastic($geoJson->toArray(), $filePath->getFilename());


//                print($filePath->__toString() . PHP_EOL);
            }
        }

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
        );
    }

}
