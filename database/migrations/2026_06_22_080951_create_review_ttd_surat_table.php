<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_ttd_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_keluar_id')->constrained('surat_keluar');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');  // superadmin
            $table->enum('keputusan', ['disetujui', 'ditolak', 'revisi']);
            $table->text('catatan')->nullable();
            $table->string('tanda_tangan')->nullable();  // path file TTD digital
            $table->timestamp('reviewed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_ttd_surat');
    }
};
