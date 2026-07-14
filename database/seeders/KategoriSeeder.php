<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::create([
            'nama' => 'BAST',
            'kode' => 'CAT-001',
            'deskripsi' => 'Berita Acara Serah Terima Barang/Jasa',
        ]);

        Kategori::create([
            'nama' => 'Service Report',
            'kode' => 'CAT-002',
            'deskripsi' => 'Laporan pemeliharaan rutin infrastruktur',
        ]);

        Kategori::create([
            'nama' => 'Laporan Kondisi Perangkat',
            'kode' => 'CAT-003',
            'deskripsi' => 'Audit mingguan kesehatan hardware kantor',
        ]);

        Kategori::create([
            'nama' => 'Surat Tugas',
            'kode' => 'CAT-004',
            'deskripsi' => 'Instruksi kerja resmi untuk dinas luar',
        ]);

        Kategori::create([
            'nama' => 'Nota Dinas',
            'kode' => 'CAT-005',
            'deskripsi' => 'Komunikasi internal antar bagian divisi',
        ]);
    }
}
