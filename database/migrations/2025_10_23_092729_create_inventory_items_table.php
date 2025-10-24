<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('purchase_order_item_id')->nullable(); // link to PO line
            $table->string('serial_number')->unique()->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->enum('status', ['in_stock', 'sold', 'returned'])->default('in_stock');
            // Audit columns
            $table->unsignedBigInteger('createdby_id')->nullable();
            $table->unsignedBigInteger('updatedby_id')->nullable();
            $table->timestamps();
            // Foreign keys
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('purchase_order_item_id')
                ->references('id')->on('purchase_order_items')
                ->onDelete('set null');

            $table->foreign('createdby_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('updatedby_id')->references('employee_id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
