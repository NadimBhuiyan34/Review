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
        Schema::create('payments', function (Blueprint $table) {

            $table->uuid('id')->primary(); // UUID as primary key
            $table->uuid('order_id');
            $table->string('payment_method'); // e.g. stripe, paypal, cod
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending'); // pending, paid, failed
            $table->decimal('amount', 10, 2);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
