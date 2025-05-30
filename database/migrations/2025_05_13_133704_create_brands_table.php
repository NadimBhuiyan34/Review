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
        Schema::create('brands', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID as primary key
            $table->string('name', 100)->unique();
            $table->string('slug')->unique(); // URL-friendly string
            $table->text('description')->nullable();
            $table->string('logo')->nullable(); // Logo path
            $table->boolean('status')->default(true); // Active/inactive brand
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
