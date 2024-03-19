<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOutOfStockToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add out of stock column to products table. will be 0 for in stock and
        // 1 for out of stock
        Schema::table('products', function (Blueprint $table) {
            $table->integer('out_of_stock')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Drop column when rolling back migration
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('out_of_stock');
        });
    }
}
