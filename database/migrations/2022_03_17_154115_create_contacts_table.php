<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('creator_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('username')->nullable();
            $table->string('full_name');
            $table->string('status')->default('Pending');
            $table->string('transit_number')->nullable();
            $table->string('institution_number')->nullable();
            $table->string('account_number')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
