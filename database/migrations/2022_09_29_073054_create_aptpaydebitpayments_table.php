<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAptpaydebitpaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aptpaydebitpayments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('type')->nullable();
            $table->string('s_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('institution_number')->nullable();
            $table->string('transit_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('external_id')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_id_one')->nullable();
            $table->string('payment_status_one')->nullable();
            $table->longText('reason')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('aptpaydebitpayments');
    }
}
