<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEftSentBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eft_sent_bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('eft_file_id');
            $table->string('record_id');
            $table->string('source')->nullable();
            $table->string('batch_id')->nullable();
            $table->bigInteger('paid_bill_id');
            $table->string('status')->nullable();
            $table->string('new_status')->nullable();
            $table->string('reason')->nullable();
            $table->string('commission')->nullable()->default('0');

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
        Schema::dropIfExists('eft_sent_bills');
    }
}
