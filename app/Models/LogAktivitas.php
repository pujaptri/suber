<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id', 'jenis_aksi', 'modul', 'deskripsi', 'data_id', 'ip_address', 'waktu_aktivitas',
    ];

    protected $casts = [
        'waktu_aktivitas' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}