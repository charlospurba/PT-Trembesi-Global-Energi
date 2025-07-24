<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rating')->check('rating >= 1 AND rating <= 5'); // Rating from 1 to 5
            $table->timestamps();
            $table->unique(['order_id', 'product_id', 'user_id']); // Prevent multiple ratings per product per order
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};