<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('createdby_id')->nullable();
            $table->unsignedBigInteger('updatedby_id')->nullable();
            $table->timestamps();

            $table->foreign('createdby_id')->references('employee_id')->on('employees')->onDelete('set null');
            $table->foreign('updatedby_id')->references('employee_id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
