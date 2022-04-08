<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->String('name')->unique();
            $table->unsignedBigInteger('collection');
            $table->String('sku')->unique();
            $table->unsignedBigInteger('size')->default('0');
            $table->unsignedBigInteger('color')->default('0');
            $table->unsignedBigInteger('material')->default('0');
            $table->decimal('selling_price', 7, 2)->default('0.00');
            $table->text('description')->nullable();
            $table->boolean('vat_applicable')->default('1');
            $table->boolean('allow_sales_zero_qty')->default('0');
            $table->foreign('collection')->references('id')->on('collections')->onDelete('cascade');
            $table->foreign('size')->references('id')->on('variants');
            $table->foreign('color')->references('id')->on('variants');
            $table->foreign('material')->references('id')->on('variants');
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
};
