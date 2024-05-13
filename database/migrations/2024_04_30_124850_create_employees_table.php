<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->date('data_hyrje');
            $table->time('ora_hyrje');
            $table->date('data_dalje');
            $table->time('ora_dalje');
            $table->time('last_check');
            $table->string('nome');
            $table->string('cognome');
            $table->string('team');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
