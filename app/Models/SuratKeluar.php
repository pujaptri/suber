<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use SoftDeletes;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'nomor_surat', 'tanggal_surat', 'perihal',
        'kategori', 'sifat_surat', 'lampiran', 'isi_surat', 'keterangan',
        'status', 'tanda_tangan_digital', 'catatan_revisi',
        'user_id', 'approved_by', 'approved_at', 'penerima',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
        'approved_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function reviews()
    {
        return $this->hasMany(ReviewTtdSurat::class);
    }
}