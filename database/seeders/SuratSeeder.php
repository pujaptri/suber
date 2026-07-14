<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;

class SuratSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $adminId = $admin ? $admin->id : 1;

        $superadmin = User::where('role', 'superadmin')->first() ?? User::first();
        $superadminId = $superadmin ? $superadmin->id : 1;

        // Surat Keluar
        SuratKeluar::create([
            'nomor_surat' => '001/BALP/PTC/V/2026',
            'penerima' => 'PTC',
            'tanggal_surat' => '2026-05-20',
            'perihal' => 'Berita Acara Laik Pakai PTC Periode Mei 2026',
            'kategori' => 'eksternal',
            'sifat_surat' => 'biasa',
            'status' => 'disetujui',
            'user_id' => $adminId,
            'approved_by' => $superadminId,
            'approved_at' => '2026-05-21 09:00:00',
        ]);

        SuratKeluar::create([
            'nomor_surat' => '002/LKP/PTC/V/2026',
            'penerima' => 'PTC',
            'tanggal_surat' => '2026-05-22',
            'perihal' => 'Laporan Kondisi Perangkat PTC Periode Mei 2026',
            'kategori' => 'eksternal',
            'sifat_surat' => 'biasa',
            'status' => 'disetujui',
            'user_id' => $adminId,
            'approved_by' => $superadminId,
            'approved_at' => '2026-05-23 10:30:00',
        ]);

        SuratKeluar::create([
            'nomor_surat' => '003/SR/PTC/V/2026',
            'penerima' => 'PTC',
            'tanggal_surat' => '2026-05-25',
            'perihal' => 'Service Report PTC Periode Mei 2026',
            'kategori' => 'eksternal',
            'sifat_surat' => 'biasa',
            'status' => 'menunggu_ttd',
            'user_id' => $adminId,
        ]);

        // Surat Masuk
        SuratMasuk::create([
            'nomor_surat' => 'INV/PTC/V/2026/012',
            'asal_surat' => 'Finance',
            'tanggal_surat' => '2026-05-18',
            'tanggal_diterima' => '2026-05-19',
            'perihal' => 'Invoice Tagihan PTC Periode Mei 2026',
            'kategori' => 'eksternal',
            'sifat_surat' => 'penting',
            'penerima' => 'Direktur Utama',
            'bagian' => 'Bagian Keuangan',
            'user_id' => $adminId,
        ]);

        SuratMasuk::create([
            'nomor_surat' => 'BAST/PTC/V/2026/045',
            'asal_surat' => 'Ivendor',
            'tanggal_surat' => '2026-05-20',
            'tanggal_diterima' => '2026-05-21',
            'perihal' => 'Berita Acara Serah Terima PTC Periode Mei 2026',
            'kategori' => 'eksternal',
            'sifat_surat' => 'biasa',
            'penerima' => 'Direktur Utama',
            'bagian' => 'Bagian Administrasi Umum',
            'user_id' => $adminId,
        ]);

        SuratMasuk::create([
            'nomor_surat' => 'SMO/PTC/V/2026/089',
            'asal_surat' => 'SMO',
            'tanggal_surat' => '2026-05-24',
            'tanggal_diterima' => '2026-05-25',
            'perihal' => 'Update Status Deployment Perangkat PTC Periode Mei 2026',
            'kategori' => 'internal',
            'sifat_surat' => 'biasa',
            'penerima' => 'Direktur Utama',
            'bagian' => 'Bagian Kepegawaian',
            'user_id' => $adminId,
        ]);
    }
}
