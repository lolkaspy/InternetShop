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
        Schema::create('order_lists', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable();
            $table->index('order_id', 'order_onlist_idx');
            $table->foreign('order_id', 'order_onlist_fk')->on('orders')->references('id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->index('product_id', 'product_onlist_idx');
            $table->foreign('product_id', 'product_onlist_fk')->on('products')->references('id');
            $table->unsignedSmallInteger('quantity');
            $table->decimal('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lists');
    }
};
