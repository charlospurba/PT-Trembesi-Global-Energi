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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('vendor');

            $table->string('status')->nullable();
            $table->string('name'); // tambahkan
            $table->string('email')->unique(); // tambahkan
            $table->string('phone_number')->nullable(); // tambahkan
            $table->string('project_name')->nullable(); // tambahkan
            $table->string('procurement_kode')->nullable(); // tambahkan
            $table->string('store_name')->nullable(); // tambahkan
            $table->string('npwp')->nullable(); // tambahkan
            $table->string('nib')->nullable(); // tambahkan
            $table->string('comp_profile')->nullable(); // tambahkan
            $table->string('izin_perusahaan')->nullable(); // tambahkan
            $table->string('sppkp')->nullable(); // tambahkan
            $table->string('struktur_organisasi')->nullable(); // tambahkan
            $table->string('daftar_pengalaman')->nullable(); // tambahkan
            $table->string('profile_picture')->nullable(); // tambahkan
            $table->string('phone')->nullable();
            $table->timestamp('email_verified_at')->nullable(); // tambahkan
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
