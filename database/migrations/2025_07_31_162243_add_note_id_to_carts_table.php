<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('note_id')->nullable()->after('product_id');
            $table->foreign('note_id')->references('id')->on('p_m_requests')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['note_id']);
            $table->dropColumn('note_id');
        });
    }
};