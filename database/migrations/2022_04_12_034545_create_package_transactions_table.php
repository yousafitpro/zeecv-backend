<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('package_id')->nullable()->default(0);
            $table->bigInteger('receiver_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('bill_id')->nullable();
            $table->string('amount');
            $table->string('type')->nullable()->default('package');
            $table->string('duration')->nullable();
            $table->string('status')->nullable()->default('Pending');
            $table->string('actual_amount')->nullable();
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
        Schema::dropIfExists('package_transactions');
    }
}
