<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_category_id')->nullable();
            $table->bigInteger('product_brand_id')->nullable();
            $table->bigInteger('business_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('sale_price',12,4)->nullable();
            $table->decimal('purchase_price',12,4)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_inventory')->default(1);
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
        Schema::dropIfExists('products');
    }
}
