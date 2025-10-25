<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            // branch & product this physical item belongs to
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('product_id');

            // incoming PO line (optional)
            $table->unsignedBigInteger('purchase_order_item_id')->nullable();

            // serial is unique (nullable if sometimes you have non-serial items, but you said computer parts are serialized)
            $table->string('serial_number')->nullable()->unique();

            // cost / current unit price
            $table->decimal('unit_price', 12, 2)->default(0);

            // sale references (nullable; set when sold/reserved)
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->unsignedBigInteger('sale_item_id')->nullable();
            $table->decimal('sold_price', 12, 2)->nullable();
            $table->timestamp('sold_at')->nullable();

            // status workflow
            $table->enum('status', ['in_stock','reserved','sold','returned'])->default('in_stock');

            // Audit columns
            $table->unsignedBigInteger('createdby_id')->nullable();
            $table->unsignedBigInteger('updatedby_id')->nullable();

            $table->timestamps();

            // foreign keys
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');

            $table->foreign('purchase_order_item_id')->references('id')->on('purchase_order_items')->onDelete('set null');

            // sale FKs set null on delete to preserve inventory row but detach sale relationship
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
            $table->foreign('sale_item_id')->references('id')->on('sale_items')->onDelete('set null');

            $table->foreign('createdby_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('updatedby_id')->references('employee_id')->on('employees')->onDelete('set null');

            // indexes for fast availability checks
            $table->index(['branch_id','product_id','status'], 'idx_inventory_branch_product_status');
            $table->index('serial_number');
        });
    }

    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            // drop FK constraints before dropping table
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['purchase_order_item_id']);
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['sale_item_id']);
            $table->dropForeign(['createdby_id']);
            $table->dropForeign(['updatedby_id']);
        });

        Schema::dropIfExists('inventory_items');
    }
}
