<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('office')->nullable();
            $table->string('name')->nullable();
            $table->string('link');
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->enum('material', ['guide', 'office','other']);
            $table->unsignedInteger('guide_id')->nullable();
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->string('type')->nullable();
            $table->string('old_creator')->nullable();
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
        Schema::dropIfExists('files');
    }
}
