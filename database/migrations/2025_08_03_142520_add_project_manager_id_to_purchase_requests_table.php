<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectManagerIdToPurchaseRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('project_manager_id')->nullable()->after('user_id');
            $table->foreign('project_manager_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('purchase_requests', function (Blueprint $table) {
            $table->dropForeign(['project_manager_id']);
            $table->dropColumn('project_manager_id');
        });
    }
}