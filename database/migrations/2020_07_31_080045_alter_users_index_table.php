<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterUsersIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
       Schema::table('files', function (Blueprint $table) {
           DB::statement('ALTER TABLE files ADD FULLTEXT `search` (`description`, `tags`, `name`, `link`)');
       });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE users DROP INDEX search');
    }
}
