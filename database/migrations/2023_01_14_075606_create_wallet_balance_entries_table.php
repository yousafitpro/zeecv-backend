<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletBalanceEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_balance_entries', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->string('title')->nullable()->default();
            $table->string('type')->nullable()->default('plus');
            $table->string('currency')->nullable()->default('CAD');
            $table->string('amount')->nullable()->default('0');
            $table->string('status')->nullable()->default('Settled');
            $table->string('added_by')->nullable()->default('user');
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
        Schema::dropIfExists('wallet_balance_entries');
    }
}
