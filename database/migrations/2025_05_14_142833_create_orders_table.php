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
        Schema::create('orders', function (Blueprint $table) {

            $table->uuid('id')->primary(); // UUID as primary key
            $table->uuid('user_id');
            $table->string('order_number')->unique(); // For human-readable tracking ID
            $table->string('status')->default('pending'); // pending, paid, shipped, completed, cancelled
            $table->decimal('total_price', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
