<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('ammount');
            $table->bigInteger('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table){
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('user_id')
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
        Schema::dropIfExists('orders');
    }
}
