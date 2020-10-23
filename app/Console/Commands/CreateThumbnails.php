<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Image;
use Intervention\Image\Exception\NotReadableException;

class CreateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:thumbnail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate all thumbnail from files/*image';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL,'en_US.UTF-8');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file_folder = storage_path('app/public/files/');
        $i = 0;
        foreach(glob($file_folder.'*.{jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF}',GLOB_BRACE) as $filename){
            $file_name = pathinfo(basename($filename), PATHINFO_FILENAME);
            $extension = pathinfo(basename($filename), PATHINFO_EXTENSION);
            $thumbnail_name = $file_name . '-thumbnail.'.$extension;
            /*
            try{
                Image::make(public_path('storage/files/'.basename($filename)) )->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('storage/thumbnail/'.basename($thumbnail_name)) );
            }
            catch(NotReadableException $e){
                $this->error("Can not read file ". $thumbnail_name);
            }
            */
            $i++;            
            if($i % 300 == 0)
                echo "Create ". $i . " thumbnails \n";
        }
        echo $i;
    }
}
