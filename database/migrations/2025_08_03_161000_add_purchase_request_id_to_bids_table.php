<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPurchaseRequestIdToBidsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            // Tambahkan kolom purchase_request_id sebagai foreign key
            // onDelete('set null') agar bid tidak terhapus jika purchase request dihapus (walau jarang terjadi)
            $table->foreignId('purchase_request_id')->nullable()->constrained('purchase_requests')->onDelete('set null')->after('cart_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropForeign(['purchase_request_id']);
            $table->dropColumn('purchase_request_id');
        });
    }
}