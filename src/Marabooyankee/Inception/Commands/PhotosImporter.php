<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/7/2014
 * Time: 4:48 PM
 */

namespace Marabooyankee\Inception\Commands;


use Carbon\Carbon;
use Elasticsearch\Client;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PhotosImporter extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inception:photo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import photos.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $path = storage_path();
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path . '\data\photo'), \RecursiveIteratorIterator::SELF_FIRST);
        /**@var \SplFileInfo $filePath */
        foreach ($iterator as $filePath) {
            if (!$filePath->isDir()) {

                $fileName = $filePath->getFilename();

                $time = substr($fileName, 0, 14);
                $year = substr($fileName, 0, 4);
                $month = substr($fileName, 4, 2);
                $day = substr($fileName, 6, 2);
                $hr = substr($fileName, 8, 2);
                $min = substr($fileName, 10, 2);
                $seconds = substr($fileName, 12, 2);

                $timeStamp = Carbon::createFromDate($year, $month, $day);
                $timeStamp->addHours($hr)->addMinutes($min)->addSeconds($seconds);

                echo $timeStamp->toDateTimeString() . PHP_EOL;


                list($date, $lat, $lng, $seq) = explode('_', $fileName);

                echo($lat);

                $photo = array(
//                    'date' => $timeStamp->toDateTimeString(),
                    'location' => [
                        'type' => 'point',
                        'coordinates' => [$lng, $lat]
                    ],
                    'url' => $fileName
                );

                $this->addToElastic($photo);

//                echo $filePath->__toString().PHP_EOL;
            }
        }
    }

    public function addToElastic(array $data)
    {
        /**@var Client $elasticClient */
        $elasticClient = app('inception:elastic-client');

        $request = array('body' => $data);
        $request['index'] = 'csv_dump';
        $request['type'] = 'photo';
//        dd($request);
         $elasticClient->index($request);

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
