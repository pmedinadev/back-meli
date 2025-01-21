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
        Schema::create('order_shipping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('address_id');
            $table->enum('delivery_status', [
                'pending',
                'in_transit',
                'delivered',
                'cancelled',
                'returned'
            ])->default('pending');
            $table->date('estimated_delivery_date');
            $table->timestamp('delivered_at')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('delivery_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_shipping');
    }
};
