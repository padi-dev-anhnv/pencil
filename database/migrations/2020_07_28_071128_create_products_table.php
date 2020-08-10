<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('guide_id');
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('color')->nullable();
            $table->integer('qty')->nullable();
            $table->string('unit')->nullable();
            $table->date('shipping_date')->nullable();
            $table->date('received_date')->nullable();
            $table->string('body')->nullable();
            $table->string('direction')->nullable();
            $table->string('proofreading')->nullable();
            $table->string('method')->nullable();
            $table->string('work')->nullable();
            $table->string('typeface')->nullable();
            $table->string('font_size')->nullable();
            $table->string('printing_color')->nullable();
            $table->string('pattern_type')->nullable();
            $table->string('pattern_text')->nullable();
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
        Schema::dropIfExists('products');
    }
}
