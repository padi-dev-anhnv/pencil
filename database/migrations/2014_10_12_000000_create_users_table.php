<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            // $table->string('email')->unique();
            $table->string('name');
            // $table->string('sale_office');
            $table->unsignedInteger('office_id')->nullable();
            $table->foreign('office_id')->references('id')->on('offices');
            $table->boolean('status')->default(1);
            // $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
