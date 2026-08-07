<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('senders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('identityId')->nullable();
            $table->string('identificationType')->nullable();
            $table->string('identificationDate')->nullable();
            $table->string('identificationDateOfExpiration')->nullable();
            $table->string('identificationLocation')->nullable();
            $table->string('identificationFile')->nullable();
            $table->string('identificationNumber')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('senders');
    }
}
