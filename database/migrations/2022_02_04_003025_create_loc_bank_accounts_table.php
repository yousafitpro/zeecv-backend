<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loc_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->string("nic_name")->nullable();
            $table->string("title")->nullable();
            $table->string("bank_id")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("access_token")->nullable();
            $table->string("is_primary")->default(false);
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
        Schema::dropIfExists('loc_bank_accounts');
    }
}
