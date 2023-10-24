<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variant_products', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('product_id')->on('tbl_product')->onDelete('cascade');
            $table->integer('sku_id')->unsigned();
            $table->foreign('sku_id')->references('sku_id')->on('sku_products')->onDelete('cascade');
            $table->integer('attr_id')->unsigned();
            $table->foreign('attr_id')->references('id')->on('tbl_attribute')->onDelete('cascade');
            $table->integer('attr_value_id')->unsigned();
            $table->foreign('attr_value_id')->references('attr_value_id')->on('tbl_attr_value')->onDelete('cascade');
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
        Schema::dropIfExists('variant_products');
    }
}
