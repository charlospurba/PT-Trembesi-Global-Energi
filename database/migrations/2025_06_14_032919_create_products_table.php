<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('supplier')->nullable();
            $table->string('name');
            $table->string('specification');
            $table->string('custom_spec')->nullable();
            $table->integer('quantity');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image_path')->nullable();
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};