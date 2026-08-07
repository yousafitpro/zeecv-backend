<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelpaysentBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telpaysent_bills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('telpay_file_id');
            $table->string('record_id');
            $table->bigInteger('paid_bill_id');
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
        Schema::dropIfExists('telpaysent_bills');
    }
}
