<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->longText('identity_id')->nullable();
            $table->string('email')->nullable();
            $table->string('commission')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('status')->nullable()->default('Pending');
            $table->string('receive_currency')->nullable();
            $table->string('mode_of_delivery')->nullable();
            $table->string('amount_country')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('iban')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('bType')->nullable();
            $table->string('amount_p_1')->nullable();
            $table->string('amount_p_2')->nullable();
            $table->string('amount_p_3')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
