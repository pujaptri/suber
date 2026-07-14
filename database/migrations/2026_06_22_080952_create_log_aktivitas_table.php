<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis_aksi');           // tambah, edit, hapus, login, logout, approve, tolak, distribusi
            $table->string('modul');                // surat_masuk, surat_keluar, pengguna, auth
            $table->text('deskripsi');              // detail aktivitas
            $table->string('data_id')->nullable();  // id record yang diaksi
            $table->string('ip_address')->nullable();
            $table->timestamp('waktu_aktivitas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
