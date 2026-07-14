<?php

namespace App\Helpers;
 
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
 
class LogHelper
{
    public static function catat(
        string $jenisAksi,
        string $modul,
        string $deskripsi,
        mixed $dataId = null
    ): void {
        // Hanya catat jika user sudah login
        if (!Auth::check()) return;
 
        LogAktivitas::create([
            'user_id'         => Auth::id(),
            'jenis_aksi'      => $jenisAksi,
            'modul'           => $modul,
            'deskripsi'       => $deskripsi,
            'data_id'         => $dataId ? (string) $dataId : null,
            'ip_address'      => Request::ip(),
            'waktu_aktivitas' => now(),
        ]);
    }
}