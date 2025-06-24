<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('supplier');
            $table->string('brand')->nullable();
            $table->string('name');
            $table->string('specification')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->json('image_paths')->nullable();
            $table->foreignId('vendor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
