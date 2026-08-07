<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender')->nullable();
            $table->bigInteger('receiver')->nullable();
            $table->string("title")->nullable();
            $table->string("type")->nullable();
            $table->string("message")->nullable();
            $table->string("web_url")->nullable();
            $table->string("app_url")->nullable();
            $table->string("action")->nullable();
            $table->string("status")->nullable()->default('created');
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
        Schema::dropIfExists('alerts');
    }
}
