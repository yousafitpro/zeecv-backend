<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMypayeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mypayees', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('payee_id')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('type')->nullable()->default('self-added');
            $table->string('nickname')->nullable();
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
        Schema::dropIfExists('mypayees');
    }
}
