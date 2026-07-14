<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('penerima')->nullable()->after('perihal');
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->string('penerima')->nullable()->after('perihal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropColumn('penerima');
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropColumn('penerima');
        });
    }
};
