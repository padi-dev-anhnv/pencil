<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

    
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        /*
        $files =   Storage::allFiles('/public/files/');
        Storage::delete($files);
        $filess =   Storage::allFiles('/public/thumbnail/');
        Storage::delete($filess);
*/
        // $this->call(FileSeeder::class);
        // $this->call(SupplierSeeder::class);
    }
}
