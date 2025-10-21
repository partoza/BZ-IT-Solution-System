<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('warranty_allowed')->default(false);
            $table->string('category_type');
            $table->string('status')->default('Active');
            $table->timestamps();
            $table->unsignedBigInteger('createdby_id')->nullable();
            $table->unsignedBigInteger('updatedby_id')->nullable();

            // Self-referencing foreign key for sub-categories
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
