<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentorders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('originating_account_id');
            $table->string('receiving_account_id');
            $table->string('type');
            $table->string('amount');
            $table->string('currency');
            $table->string('direction');
            $table->string('status')->default('created');
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
        Schema::dropIfExists('paymentorders');
    }
}
