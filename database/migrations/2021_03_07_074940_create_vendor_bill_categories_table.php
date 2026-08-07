<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorBillCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_bill_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_bill_id');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->string('status')
                ->default('active')
                ->nullable();
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
        Schema::dropIfExists('vendor_bill_categories');
    }
}
