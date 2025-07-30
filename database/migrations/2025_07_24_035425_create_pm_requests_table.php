<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('p_m_requests', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('item');
            $table->string('specification');
            $table->string('unit');
            $table->integer('qty');
            $table->date('eta')->nullable();
            $table->text('remark');
            $table->decimal('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_m_requests');
    }
};
