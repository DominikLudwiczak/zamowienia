<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->date('start');
            $table->date('end');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('who_added')->unsigned();
            $table->integer('confirmed')->default(0);
            $table->bigInteger('who_conf')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('vacations', function (Blueprint $table){
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('who_added')
                ->references('id')
                ->on('users');

            $table->foreign('who_conf')
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
        Schema::dropIfExists('vacations');
    }
}
