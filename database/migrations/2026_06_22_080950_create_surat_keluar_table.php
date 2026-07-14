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
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->string('tujuan_surat');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->enum('kategori', ['internal', 'eksternal', 'undangan', 'pemberitahuan', 'lainnya'])->default('lainnya');
            $table->enum('sifat_surat', ['biasa', 'penting', 'rahasia', 'sangat_rahasia'])->default('biasa');
            $table->string('lampiran')->nullable();  // path file PDF
            $table->text('isi_surat')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', [
                'menunggu_ttd',    // baru dibuat admin, menunggu persetujuan superadmin
                'disetujui',       // sudah TTD oleh superadmin
                'ditolak',         // ditolak superadmin
                'revisi'           // perlu revisi
            ])->default('menunggu_ttd');
            $table->string('tanda_tangan_digital')->nullable();  // path file TTD
            $table->text('catatan_revisi')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // admin pembuat
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');  // superadmin yang approve
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
