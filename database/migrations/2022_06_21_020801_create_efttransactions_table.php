<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEfttransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efttransactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('sender_id')->nullable();
            $table->bigInteger('receiver_id')->nullable();
            $table->bigInteger('eft_file_id');
            $table->string('record_id');
            $table->string('institution_number');
            $table->string('transit_number');
            $table->string('account_number');
            $table->string('transaction_id')->nullable();
            $table->string('amount')->nullable()->default('0');
            $table->string('direction')->nullable();
            $table->string('status')->default('Pending');
            $table->string('commission')->nullable()->default('0');
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
        Schema::dropIfExists('efttransactions');
    }
}
