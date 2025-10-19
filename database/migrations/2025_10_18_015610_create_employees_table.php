<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('employee_id');
            $table->unsignedBigInteger('branch_id'); // FK to branches

            $table->string('first_name');
            $table->string('last_name');
            $table->string('role');
            $table->string('avatar')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email_address')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->boolean('active_status')->default(true);
            $table->unsignedBigInteger('createdby_id')->nullable();
            $table->timestamp('created_date')->useCurrent();
            $table->unsignedBigInteger('updatedby_id')->nullable();
            $table->timestamp('updated_date')->nullable()->useCurrentOnUpdate();

            // Foreign keys
            $table->foreign('branch_id')
                  ->references('branch_id')
                  ->on('branches')
                  ->onDelete('cascade');

            $table->foreign('createdby_id')
                  ->references('employee_id')
                  ->on('employees')
                  ->onDelete('set null');

            $table->foreign('updatedby_id')
                  ->references('employee_id')
                  ->on('employees')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
