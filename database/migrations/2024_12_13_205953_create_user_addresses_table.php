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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('street_address');
            $table->boolean('no_street_number')->default(false);
            $table->string('zip_code', 5);
            $table->boolean('unknown_zip_code')->default(false);
            $table->string('state');
            $table->string('municipality');
            $table->string('locality');
            $table->string('neighborhood');
            $table->string('interior_number')->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->enum('address_type', ['residential', 'business']);
            $table->string('contact_name');
            $table->string('contact_phone');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
