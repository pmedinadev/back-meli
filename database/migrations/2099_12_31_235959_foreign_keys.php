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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('wishlist_products', function (Blueprint $table) {
            $table->foreign('wishlist_id')
                ->references('id')
                ->on('wishlists')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('cart_products', function (Blueprint $table) {
            $table->foreign('cart_id')
                ->references('id')
                ->on('carts')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::table('product_photos', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreign('seller_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('order_shipping', function (Blueprint $table) {
            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreign('address_id')
                ->references('id')
                ->on('user_addresses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['category_id']);
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('wishlist_products', function (Blueprint $table) {
            $table->dropForeign(['wishlist_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('cart_products', function (Blueprint $table) {
            $table->dropForeign(['cart_id']);
            $table->dropForeign(['product_id']);
        });

        Schema::table('product_photos', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('user_addresses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['seller_id']);
        });

        Schema::table('order_shipping', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['address_id']);
        });
    }
};
