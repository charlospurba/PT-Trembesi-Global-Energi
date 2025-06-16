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
            $table->string('brand');
            $table->string('name');
            $table->string('specification')->nullable();
            $table->string('unit')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->json('image_paths')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

