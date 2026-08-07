<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationoffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicationoffers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_application_id');
            $table->bigInteger('lender_id');
            $table->string('reference');
            $table->string('status')->default('Pending');
            $table->longText('lender_comment')->nullable();
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
        Schema::dropIfExists('applicationoffers');
    }
}
