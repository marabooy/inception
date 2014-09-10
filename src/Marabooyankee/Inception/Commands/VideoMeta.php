<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/10/2014
 * Time: 6:29 PM
 */

namespace Marabooyankee\Inception\Commands;


use Carbon\Carbon;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class VideoMeta extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'inception:video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import video meta data.';

    public function fire()
    {

        $path = storage_path();
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path . '\data\video'), \RecursiveIteratorIterator::SELF_FIRST);
        /**@var \SplFileInfo $filePath */
        foreach ($iterator as $filePath) {
            if (!$filePath->isDir()) {
                if ($filePath->getExtension() == 'mp4') {

                    $fileName = pathinfo($filePath->__toString(), PATHINFO_FILENAME);

                    $fileDir = pathinfo($filePath->__toString(), PATHINFO_DIRNAME);
//                    dd ($fileName);

                    $srtFile = $fileName . ".srt";

                    $srtFile = new \SplFileObject($fileDir . '/' . $srtFile);

                    $srtFile->seek(2);
//                    $srtFile->fseek(3,SEEK_SET);
                    $gpsTrace = array();
                    $timeTrace = array();

                    while (!$srtFile->eof()) {
                        $timeValues = $srtFile->fgets();

                        $gpsValues = $srtFile->fgets();

                        $dateFields = array_values(array_filter(explode(' ', $timeValues)));
                        print_r($dateFields);
//                        die();
                        if (count($dateFields) == 5)
                            list(, $date, $time) = $dateFields;
                        if (count($dateFields) == 6)
                            list(, , $date, $time) = $dateFields;




                        $dateTime = Carbon::createFromFormat('d.m.Y H:i:s', $date . ' ' . $time);
                        echo $dateTime->toDateTimeString();

                        array_push($timeTrace,$dateTime->toDateTimeString());

                        $values = array_filter(explode(' ', $gpsValues));
                        $data = array_values($values);

                        list(, $lat, , $lng) = $data;

                        array_push($gpsTrace, [floatval($lng), floatval($lat)]);

                        $srtFile->seek(4 + $srtFile->key());
//                        $srtFile->fseek(5,SEEK_CUR);

                    }

                    $videoMetaData = array(
                        'geometry' => [
                            'type' => 'multipoint',
                            'coordinates' => $gpsTrace
                        ],
                        'properties' => [
                            'time' => $timeTrace,
                            'start_time' => array_shift($timeTrace),
                            'end_time' => array_pop($timeTrace),
                            'url' => $filePath->getFilename()
                        ],


                    );
                    $this->saveToElastic($videoMetaData);

                }
            }
        }


    }

    public function  saveToElastic(array $data)
    {
        /**@var Client $elasticClient */
        $elasticClient = app('inception:elastic-client');

        $request = array('body' => $data);
        $request['index'] = 'csv_dump';
        $request['type'] = 'video';
//        dd($request);
        $elasticClient->index($request);
    }

} 