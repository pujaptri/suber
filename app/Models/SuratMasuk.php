<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use SoftDeletes;

    protected $table = 'surat_masuk';

    protected $fillable = [
        'nomor_surat', 'asal_surat', 'tanggal_diterima', 'tanggal_surat',
        'perihal', 'kategori', 'sifat_surat', 'lampiran', 'keterangan',
        'status_distribusi', 'user_id', 'penerima', 'bagian',
    ];

    protected $casts = [
        'tanggal_diterima' => 'date',
        'tanggal_surat'    => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}