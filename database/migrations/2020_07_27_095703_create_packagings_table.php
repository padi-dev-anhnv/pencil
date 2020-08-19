<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packagings', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('printing')->nullable();
            $table->boolean('proofreading')->nullable();
            $table->string('material')->nullable();
            $table->string('number_of_page')->nullable();
            $table->string('top_font')->nullable();
            $table->string('top_color')->nullable();
            $table->text('top_text')->nullable();
            $table->string('bottom_font')->nullable();
            $table->string('bottom_color')->nullable();
            $table->text('bottom_text')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packagings');
    }
}
