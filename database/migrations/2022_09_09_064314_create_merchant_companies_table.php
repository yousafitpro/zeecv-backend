<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_companies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string("short_name")->nullable();
            $table->string("long_name")->nullable();
            $table->string("logo")->nullable();
            $table->text("short_details")->nullable();
            $table->longText("long_details")->nullable();
            $table->string('commission')->nullable()->default('0');
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("zipcode")->nullable();
            $table->string("dateofbirth")->nullable();
            $table->string("street")->nullable();
            $table->string("city")->nullable();
            $table->string("country")->nullable();
            $table->string("institution_number")->nullable();
            $table->string("branch_number")->nullable();
            $table->string("account_number")->nullable();
            $table->string("card_number")->nullable();
            $table->string("card_expiration_date")->nullable();
            $table->string("external_identity")->nullable();
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
        Schema::dropIfExists('merchant_companies');
    }
}
