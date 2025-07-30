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
            $table->unsignedBigInteger('user_id'); // Tambahkan kolom user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key ke tabel users
            $table->string('project_name');
            $table->string('procurement_kode');
            $table->string('item');
            $table->string('specification');
            $table->string('unit');
            $table->integer('qty');
            $table->date('eta')->nullable();
            $table->text('remark');
            $table->decimal('price', 15, 2); // beri precision dan scale
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
