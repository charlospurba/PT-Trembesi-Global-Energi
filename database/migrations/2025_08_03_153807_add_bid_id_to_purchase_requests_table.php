<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBidIdToPurchaseRequestsTable extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('bid_id')->nullable()->after('cart_id');
            $table->foreign('bid_id')->references('id')->on('bids')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropForeign(['bid_id']);
            $table->dropColumn('bid_id');
        });
    }
}