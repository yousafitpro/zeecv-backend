<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBillsFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_bills_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('zpayd_file_id')->nullable();
            $table->bigInteger('file_sequence')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('status')->nullable()->default('Created');
            $table->text('bill_file_path')->nullable();
            $table->text('bill_file_report_path')->nullable();
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
        Schema::dropIfExists('company_bills_files');
    }
}
