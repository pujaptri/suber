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
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('asal_surat');
            $table->date('tanggal_diterima');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->enum('kategori', ['internal', 'eksternal', 'undangan', 'pemberitahuan', 'lainnya'])->default('lainnya');
            $table->enum('sifat_surat', ['biasa', 'penting', 'rahasia', 'sangat_rahasia'])->default('biasa');
            $table->string('lampiran')->nullable();  // path file PDF
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // admin yang input
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
