<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelpaybillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telpaybills', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->text('reference');
            $table->bigInteger('file_id')->nullable();
            $table->string('name');
            $table->string('email');
            $table->text('code');
            $table->text('actual_amount');
            $table->text('account_number');
            $table->string('date');
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
        Schema::dropIfExists('telpaybills');
    }
}
