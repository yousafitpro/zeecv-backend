<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_bill_id')->nullable();
            $table->unsignedBigInteger('vendor_bill_category_id')->nullable();

            $table->decimal('amount', 50, 4)->nullable();
            $table->decimal('interest_amount', 50, 4)->nullable();
            $table->string('actual_amount')->nullable();
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
        Schema::dropIfExists('paid_bills');
    }
}
