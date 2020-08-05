<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGuideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('office');
            // $table->string('assign');
            $table->string('number');
            $table->unsignedInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('users');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('store_code');
            $table->boolean('last_exist');
            $table->date('last_date')->nullable();
            $table->string('last_numb')->nullable();
            $table->string('customer_name');  
            $table->string('curator');  
            $table->date('shipping_date'); 
            $table->date('received_date'); 
            $table->unsignedInteger('clone_id')->nullable();
            // $table->foreign('clone_id')->references('id')->on('users');
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
        Schema::dropIfExists('guides');
    }
}
