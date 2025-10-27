<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sales_number')->unique();

            // branch that made the sale
            $table->unsignedBigInteger('branch_id');
            // employee who handled the sale (nullable)
            $table->unsignedBigInteger('employee_id')->nullable();
            // customer who made the purchase (optional)
            $table->unsignedBigInteger('customer_id')->nullable();

            // payment details
            $table->enum('payment_method', ['cash', 'gcash'])->default('cash');
            $table->string('payment_reference')->nullable(); // e.g. GCASH ref number or receipt number

            // status tracking
            $table->enum('status', ['draft','reserved','completed','cancelled'])->default('draft');

            // monetary fields
            $table->decimal('amount_paid', 12, 2)->default(0);
            $table->decimal('change', 12, 2)->default(0);
            $table->decimal('sub_total', 12, 2)->default(0);
            $table->decimal('tax_total', 12, 2)->default(0);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);

            $table->timestamp('sold_at')->nullable();

            // audit
            $table->unsignedBigInteger('createdby_id')->nullable();
            $table->unsignedBigInteger('updatedby_id')->nullable();

            $table->timestamps();

            // foreign keys (assumes your branches PK is branch_id and employees PK is employee_id)
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');

            $table->foreign('createdby_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('updatedby_id')->references('employee_id')->on('employees')->onDelete('set null');

            // helpful index
            $table->index(['branch_id', 'sold_at'], 'idx_sales_branch_soldat');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // drop foreign keys first (some DBs require explicit drops)
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['createdby_id']);
            $table->dropForeign(['updatedby_id']);
        });

        Schema::dropIfExists('sales');
    }
}
