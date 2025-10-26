<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('product_id');

            // quantity and pricing
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('line_discount', 12, 2)->default(0);
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('line_total', 12, 2)->default(0);
            $table->timestamps();

            // foreign keys
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('restrict');

            // helpful index for queries
            $table->index(['sale_id', 'product_id'], 'idx_saleitems_sale_product');
        });
    }

    public function down()
    {
        Schema::table('sale_items', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::dropIfExists('sale_items');
    }
}
