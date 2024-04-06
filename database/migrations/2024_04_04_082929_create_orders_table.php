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
            $table->date('date');
            $table->string('client_name',255);
            $table->string('client_contact',255);
            $table->string('sub_total',255);
            $table->string('vat',255);
            $table->string('total_amount',255);
            $table->string('discount',255);
            $table->string('grand_total',255);
            $table->string('paid',255);
            $table->string('due',255);
            $table->integer('payment_type');
            $table->integer('payment_status');
            $table->integer('payment_place');
            $table->string('gstn',255);
            $table->integer('order_status')->default(0);
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('orders');
    }
}

