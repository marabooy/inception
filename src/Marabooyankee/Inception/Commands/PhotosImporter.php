<?php
/**
 * Created by PhpStorm.
 * User: David Kaguma
 * Date: 9/7/2014
 * Time: 4:48 PM
 */

namespace Marabooyankee\Inception\Commands;


use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PhotosImporter extends Command {

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
        //
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
