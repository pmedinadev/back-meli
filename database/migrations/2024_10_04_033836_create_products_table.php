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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();;
            $table->text('description')->nullable();;
            $table->string('condition')->nullable();;
            $table->integer('stock')->nullable();;
            $table->string('upc')->nullable();
            $table->string('sku')->nullable();
            $table->decimal('price',)->nullable();
            $table->string('publication_type')->nullable();
            $table->string('warranty_type')->nullable();
            $table->integer('warranty_duration')->nullable();
            $table->string('warranty_duration_type')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
