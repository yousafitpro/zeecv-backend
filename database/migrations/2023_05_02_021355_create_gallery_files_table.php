<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('store_by_name')->nullable();
            $table->string('name')->nullable();
            $table->string('original_name')->nullable();
            $table->string('extension')->nullable();
            $table->string('link')->nullable();
            $table->string('size')->nullable();
            $table->string('type')->nullable()->default('file');
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
        Schema::dropIfExists('gallery_files');
    }
}
