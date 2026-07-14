<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewTtdSurat extends Model
{
    protected $table = 'review_ttd_surat';

    protected $fillable = [
        'surat_keluar_id', 'reviewer_id', 'keputusan', 'catatan', 'tanda_tangan', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function suratKeluar()
    {
        return $this->belongsTo(SuratKeluar::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}