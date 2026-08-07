<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('transaction_date')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('status')->nullable();
            $table->string('aptpay_identity')->nullable();
            $table->longText('transaction_details')->nullable();
            $table->string('external_transaction_id')->nullable();
            $table->string('gateway_customer_id')->nullable();
            $table->string('commission')->nullable()->default('0');
            $table->string('is_withdrawn')->nullable()->default('No');
            $table->longText('reason')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchant_offers');
    }
}
