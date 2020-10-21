<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedulers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start');
            $table->dateTime('end');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('who_added')->unsigned();
            $table->timestamps();
        });

        Schema::table('vacations', function (Blueprint $table){
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('who_added')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedulers');
    }
}
