<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('vendor');
            $table->decimal('total_price', 15, 2);
            $table->string('full_name');
            $table->string('country');
            $table->string('postal_code');
            $table->string('street_address');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('status')->default('Awaiting Shipment');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};