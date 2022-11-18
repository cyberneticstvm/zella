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
        Schema::table('sales', function (Blueprint $table) {
            $table->decimal('old_product_total', 6, 2)->default(0)->after('payment_status');
        });
        Schema::table('sales_details', function (Blueprint $table) {
            $table->decimal('old_product_price', 5, 2)->default(0)->after('old_product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn('old_product_total');
        });
        Schema::table('sales_details', function (Blueprint $table) {
            $table->dropColumn('old_product_price');
        });
    }
};
