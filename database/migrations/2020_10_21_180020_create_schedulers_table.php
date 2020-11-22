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
            $table->date('date');
            $table->time('start', 0);
            $table->time('end', 0);
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('shop_id')->unsigned();
            $table->bigInteger('who_added')->unsigned();
            $table->timestamps();
        });

        Schema::table('schedulers', function (Blueprint $table){
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('who_added')
                ->references('id')
                ->on('users');

            $table->foreign('shop_id')
                ->references('id')
                ->on('shops');
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
