<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentToRecipientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ///asdadasdsdfsdf
        Schema::create('payment_to_recipients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('recipient_id');
            $table->string('send_amount')->nullable()->default('CAD');
            $table->string('receive_currency')->nullable();
            $table->string('mode_of_delivery')->nullable();
            $table->string('country')->nullable();
            $table->string('bank')->nullable();
            $table->string('branch')->nullable();
            $table->string('iban')->nullable();
            $table->string('purpose')->nullable();
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
        Schema::dropIfExists('payment_to_recipients');
    }
}
