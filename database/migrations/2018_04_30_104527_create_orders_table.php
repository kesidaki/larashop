<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('buyer_id')->nullable()->unsigned();
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('profession')->nullable();
            $table->string('doy')->nullable();
            $table->string('afm', 10)->nullable();
            $table->string('address');
            $table->smallInteger('tk');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('phone');
            $table->string('phone_2')->nullable();
            $table->string('email');
            $table->integer('shipping_id')->unsigned();
            $table->float('subtotal');
            $table->float('tax');
            $table->float('shipping');
            $table->float('total');
            $table->string('payment');

            $table->timestamps();

            $table->foreign('buyer_id')->references('id')->on('users');
            $table->foreign('shipping_id')->references('id')->on('shipping');
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
