<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppnotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appnotifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->json('users')->nullable();
            $table->string('app')->nullable()->default('Merchant');
            $table->string('title')->nullable();
            $table->string('front_color')->nullable();
            $table->string('place')->nullable();
            $table->string('back_color')->nullable();
            $table->longText('text')->nullable()->default('');
            $table->string('is_close_able')->nullable();
            $table->string('type')->nullable()->default('warning');
            $table->string('design_type')->nullable()->default('bar');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->string('is_expired')->nullable()->default('false');
            $table->string('is_need_sign')->nullable()->default('false');
            $table->string('status')->nullable()->default('Active');
            $table->string('image')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('appnotifications');
    }
}
