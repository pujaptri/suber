<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogAktivitas;
use Carbon\Carbon;

class LogAktivitasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Hari ini (Harian, Mingguan, Bulanan)
        LogAktivitas::create([
            'user_id' => 1, // Super Admin
            'jenis_aksi' => 'tambah',
            'modul' => 'surat_masuk',
            'deskripsi' => 'Mengunggah file "Surat_Edaran_Q4.pdf" ke kategori Internal.',
            'data_id' => '10',
            'ip_address' => '192.168.1.10',
            'waktu_aktivitas' => $now->copy()->subHours(2),
        ]);

        LogAktivitas::create([
            'user_id' => 2, // Admin 1
            'jenis_aksi' => 'edit',
            'modul' => 'kategori',
            'deskripsi' => 'Mengubah nama kategori "Laporan Luar" menjadi "Laporan Eksternal".',
            'data_id' => '2',
            'ip_address' => '192.168.1.12',
            'waktu_aktivitas' => $now->copy()->subHours(4),
        ]);

        LogAktivitas::create([
            'user_id' => 1, // Super Admin
            'jenis_aksi' => 'hapus',
            'modul' => 'pengguna',
            'deskripsi' => 'Menghapus akun user ID #442 (M. Rasyid) dari sistem.',
            'data_id' => '442',
            'ip_address' => '192.168.1.10',
            'waktu_aktivitas' => $now->copy()->subHours(6),
        ]);

        // 2. Kemarin (Mingguan, Bulanan)
        LogAktivitas::create([
            'user_id' => 3, // Admin 2
            'jenis_aksi' => 'login',
            'modul' => 'auth',
            'deskripsi' => 'User berhasil masuk ke dalam sistem dari alamat IP 192.168.1.15.',
            'data_id' => null,
            'ip_address' => '192.168.1.15',
            'waktu_aktivitas' => $now->copy()->subDay()->subHours(1),
        ]);

        LogAktivitas::create([
            'user_id' => 2, // Admin 1
            'jenis_aksi' => 'edit',
            'modul' => 'surat_keluar',
            'deskripsi' => 'Memperbarui metadata pada surat "Undangan Rapat Koordinasi".',
            'data_id' => '5',
            'ip_address' => '192.168.1.12',
            'waktu_aktivitas' => $now->copy()->subDay()->subHours(3),
        ]);

        // 3. Tiga hari lalu (Mingguan, Bulanan)
        LogAktivitas::create([
            'user_id' => 1, // Super Admin
            'jenis_aksi' => 'approve',
            'modul' => 'surat_keluar',
            'deskripsi' => 'Menyetujui (digital signature) surat keluar dengan nomor 05/SK-ADM/2026.',
            'data_id' => '5',
            'ip_address' => '192.168.1.10',
            'waktu_aktivitas' => $now->copy()->subDays(3),
        ]);

        // 4. Dua minggu lalu (Bulanan saja)
        LogAktivitas::create([
            'user_id' => 4, // Admin 3
            'jenis_aksi' => 'distribusi',
            'modul' => 'surat_masuk',
            'deskripsi' => 'Mendistribusikan surat masuk BAST ke unit kerja Humas.',
            'data_id' => '3',
            'ip_address' => '192.168.1.18',
            'waktu_aktivitas' => $now->copy()->subWeeks(2),
        ]);

        // 5. Bulan lalu (Luar bulanan)
        LogAktivitas::create([
            'user_id' => 5, // Admin 4
            'jenis_aksi' => 'logout',
            'modul' => 'auth',
            'deskripsi' => 'User berhasil keluar dari sistem.',
            'data_id' => null,
            'ip_address' => '192.168.1.20',
            'waktu_aktivitas' => $now->copy()->subMonth()->subDays(2),
        ]);
    }
}
