<?php
// ============================================================
// LOKASI FILE : app/Http/Controllers/SuratKeluarController.php
// CARA BUAT   : php artisan make:controller SuratKeluarController
// ============================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratKeluar;
use App\Models\ReviewTtdSurat;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class SuratKeluarController extends Controller
{
    // ══════════════════════════════════════════════════════════
    // INDEX – Daftar surat keluar dengan search & filter
    // GET /surat-keluar
    // ══════════════════════════════════════════════════════════
    public function index(Request $request)
    {
        $query = SuratKeluar::with(['user', 'approvedBy'])->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nomor_surat',   'like', "%$s%")
                  ->orWhere('penerima',     'like', "%$s%")
                  ->orWhere('perihal',     'like', "%$s%");
            });
        }

        if ($request->filled('status'))         $query->where('status', $request->status);
        if ($request->filled('kategori'))       $query->where('kategori', $request->kategori);
        if ($request->filled('sifat_surat'))    $query->where('sifat_surat', $request->sifat_surat);
        if ($request->filled('tanggal_dari'))   $query->whereDate('tanggal_surat', '>=', $request->tanggal_dari);
        if ($request->filled('tanggal_sampai')) $query->whereDate('tanggal_surat', '<=', $request->tanggal_sampai);

        $suratKeluar = $query->paginate(10)->withQueryString();

        return view('surat-keluar.index', compact('suratKeluar'));
    }

    // ══════════════════════════════════════════════════════════
    // CREATE – Form buat surat keluar baru
    // GET /surat-keluar/tambah
    // ══════════════════════════════════════════════════════════
    public function create()
    {
        $tahun         = now()->year;
        $urutan        = SuratKeluar::withTrashed()->whereYear('created_at', $tahun)->count() + 1;
        $nomorOtomatis = 'SK/PMO/' . $tahun . '/' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return view('surat-keluar.create', compact('nomorOtomatis'));
    }

    // ══════════════════════════════════════════════════════════
    // STORE – Simpan surat keluar baru
    // POST /surat-keluar/simpan
    // ══════════════════════════════════════════════════════════
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'   => 'required|string|max:100|unique:surat_keluar,nomor_surat',
            'penerima'      => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'nullable|string|max:500',
            'kategori'      => 'required|in:internal,eksternal,undangan,pemberitahuan,lainnya',
            'sifat_surat'   => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'isi_surat'     => 'nullable|string',
            'keterangan'    => 'nullable|string|max:1000',
            'lampiran'      => 'required|file|mimes:pdf,docx,doc,xls,xlsx|max:5120',
        ], [
            'nomor_surat.unique' => 'Nomor surat sudah terdaftar di sistem.',
            'lampiran.required'  => 'Lampiran wajib diunggah.',
            'lampiran.mimes'     => 'Format lampiran tidak didukung. Gunakan PDF, DOCX, atau XLS.',
            'lampiran.max'       => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['lampiran'] = $file->storeAs('lampiran/surat-keluar', $filename, 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'menunggu_ttd';

        $surat = SuratKeluar::create($validated);

        LogHelper::catat(
            'tambah', 'surat_keluar',
            Auth::user()->name . ' membuat surat keluar: ' . $surat->nomor_surat,
            $surat->id
        );

        return redirect()
            ->route('surat-keluar.index')
            ->with('success', 'Surat keluar ' . $surat->nomor_surat . ' berhasil dibuat dan menunggu persetujuan SuperAdmin.');
    }

    // ══════════════════════════════════════════════════════════
    // SHOW – Detail surat keluar + riwayat review TTD
    // GET /surat-keluar/{id}
    // ══════════════════════════════════════════════════════════
    public function show(string $id)
    {
        $surat = SuratKeluar::with([
            'user',
            'approvedBy',
            'reviews.reviewer',
        ])->findOrFail($id);

        return view('surat-keluar.show', compact('surat'));
    }

    // ══════════════════════════════════════════════════════════
    // EDIT – Form edit surat keluar
    // GET /surat-keluar/{id}/edit
    // Hanya bisa edit jika status masih menunggu_ttd atau revisi
    // ══════════════════════════════════════════════════════════
    public function edit(string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if (!Auth::user()->isSuperAdmin() && !in_array($surat->status, ['menunggu_ttd', 'revisi'])) {
            return redirect()
                ->route('surat-keluar.show', $id)
                ->with('error', 'Surat yang sudah disetujui atau ditolak tidak dapat diedit.');
        }

        return view('surat-keluar.edit', compact('surat'));
    }

    // ══════════════════════════════════════════════════════════
    // UPDATE – Simpan perubahan surat keluar
    // PUT /surat-keluar/{id}/update
    // ══════════════════════════════════════════════════════════
    public function update(Request $request, string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if (!Auth::user()->isSuperAdmin() && !in_array($surat->status, ['menunggu_ttd', 'revisi'])) {
            return redirect()
                ->route('surat-keluar.show', $id)
                ->with('error', 'Surat ini tidak dapat diedit.');
        }

        $hasExistingLampiran = $surat->lampiran && ($request->input('hapus_lampiran') !== '1');

        $rules = [
            'nomor_surat'   => 'required|string|max:100|unique:surat_keluar,nomor_surat,' . $id,
            'penerima'      => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'perihal'       => 'nullable|string|max:500',
            'kategori'      => 'required|in:internal,eksternal,undangan,pemberitahuan,lainnya',
            'sifat_surat'   => 'required|in:biasa,penting,rahasia,sangat_rahasia',
            'isi_surat'     => 'nullable|string',
            'keterangan'    => 'nullable|string|max:1000',
        ];

        if ($hasExistingLampiran) {
            $rules['lampiran'] = 'nullable|file|mimes:pdf,docx,doc,xls,xlsx|max:5120';
        } else {
            $rules['lampiran'] = 'required|file|mimes:pdf,docx,doc,xls,xlsx|max:5120';
        }

        $validated = $request->validate($rules, [
            'nomor_surat.unique' => 'Nomor surat sudah digunakan oleh surat lain.',
            'lampiran.required'  => 'Lampiran wajib diunggah.',
            'lampiran.mimes'     => 'Format lampiran tidak didukung. Gunakan PDF, DOCX, atau XLS.',
            'lampiran.max'       => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($surat->lampiran && Storage::disk('public')->exists($surat->lampiran)) {
                Storage::disk('public')->delete($surat->lampiran);
            }
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['lampiran'] = $file->storeAs('lampiran/surat-keluar', $filename, 'public');
        } elseif ($request->input('hapus_lampiran') == '1') {
            if ($surat->lampiran && Storage::disk('public')->exists($surat->lampiran)) {
                Storage::disk('public')->delete($surat->lampiran);
            }
            $validated['lampiran'] = null;
        }

        // Kalau sebelumnya revisi lalu diedit ulang → kembalikan ke menunggu_ttd
        if ($surat->status === 'revisi') {
            $validated['status']         = 'menunggu_ttd';
            $validated['catatan_revisi'] = null;
        }

        $surat->update($validated);

        LogHelper::catat(
            'edit', 'surat_keluar',
            Auth::user()->name . ' mengubah surat keluar: ' . $surat->nomor_surat,
            $surat->id
        );

        return redirect()
            ->route('surat-keluar.show', $id)
            ->with('success', 'Surat keluar berhasil diperbarui.');
    }

    // ══════════════════════════════════════════════════════════
    // DESTROY – Hapus surat keluar (soft delete)
    // DELETE /surat-keluar/{id}/hapus
    // ══════════════════════════════════════════════════════════
    public function destroy(string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if (!Auth::user()->isSuperAdmin() && $surat->status === 'disetujui') {
            return redirect()
                ->route('surat-keluar.show', $id)
                ->with('error', 'Surat yang sudah disetujui tidak dapat dihapus.');
        }

        $nomor = $surat->nomor_surat;

        if ($surat->lampiran && Storage::disk('public')->exists($surat->lampiran)) {
            Storage::disk('public')->delete($surat->lampiran);
        }

        $surat->delete();

        LogHelper::catat(
            'hapus', 'surat_keluar',
            Auth::user()->name . ' menghapus surat keluar: ' . $nomor,
            $id
        );

        return redirect()
            ->route('surat-keluar.index')
            ->with('success', 'Surat keluar ' . $nomor . ' berhasil dihapus.');
    }

    // ══════════════════════════════════════════════════════════
    // TINJAU – Halaman Review & TTD Surat Keluar untuk SuperAdmin
    // GET /surat-keluar/{id}/tinjau
    // ══════════════════════════════════════════════════════════
    public function tinjau(string $id)
    {
        $surat = SuratKeluar::with([
            'user',
            'approvedBy',
            'reviews.reviewer',
        ])->findOrFail($id);

        if ($surat->status !== 'menunggu_ttd') {
            return redirect()
                ->route('surat-keluar.show', $id)
                ->with('error', 'Hanya surat berstatus "Menunggu TTD" yang dapat ditinjau.');
        }

        // Hitung antrian persetujuan secara dinamis
        $pendingIds = SuratKeluar::where('status', 'menunggu_ttd')
            ->orderBy('id', 'asc')
            ->pluck('id')
            ->toArray();

        $totalPending = count($pendingIds);
        $currentQueueIndex = array_search($surat->id, $pendingIds);
        $currentQueueNumber = $currentQueueIndex !== false ? $currentQueueIndex + 1 : 1;

        return view('surat-keluar.tinjau', compact('surat', 'totalPending', 'currentQueueNumber'));
    }

    // ══════════════════════════════════════════════════════════
    // SETUJUI – SuperAdmin menyetujui surat keluar + upload TTD
    // POST /surat-keluar/{id}/setujui
    // ══════════════════════════════════════════════════════════
    public function setujui(Request $request, string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if ($surat->status !== 'menunggu_ttd') {
            return redirect()
                ->route('surat-keluar.show', $id)
                ->with('error', 'Hanya surat berstatus "Menunggu TTD" yang dapat disetujui.');
        }

        $request->validate([
            'catatan'      => 'nullable|string|max:500',
        ]);

        $surat->update([
            'status'               => 'disetujui',
            'approved_by'          => Auth::id(),
            'approved_at'          => now(),
            'tanda_tangan_digital' => null,
            'catatan_revisi'       => null,
        ]);

        ReviewTtdSurat::create([
            'surat_keluar_id' => $surat->id,
            'reviewer_id'     => Auth::id(),
            'keputusan'       => 'disetujui',
            'catatan'         => $request->catatan ?? 'Disetujui oleh ' . Auth::user()->name . '.',
            'tanda_tangan'    => null,
            'reviewed_at'     => now(),
        ]);

        LogHelper::catat(
            'approve', 'surat_keluar',
            Auth::user()->name . ' menyetujui surat keluar: ' . $surat->nomor_surat,
            $surat->id
        );

        return redirect()
            ->route('surat-keluar.show', $id)
            ->with('success', 'Surat keluar berhasil disetujui.');
    }

    // ══════════════════════════════════════════════════════════
    // TOLAK – SuperAdmin menolak atau meminta revisi
    // POST /surat-keluar/{id}/tolak
    // ══════════════════════════════════════════════════════════
    public function tolak(Request $request, string $id)
    {
        $surat = SuratKeluar::findOrFail($id);

        if ($surat->status !== 'menunggu_ttd') {
            return redirect()
                ->route('surat-keluar.show', $id)
                ->with('error', 'Hanya surat berstatus "Menunggu TTD" yang dapat ditolak.');
        }

        $request->validate([
            'keputusan' => 'required|in:ditolak,revisi',
            'catatan'   => 'required|string|max:500',
        ], [
            'catatan.required' => 'Catatan wajib diisi saat menolak atau meminta revisi.',
        ]);

        $surat->update([
            'status'         => $request->keputusan,
            'catatan_revisi' => $request->catatan,
        ]);

        ReviewTtdSurat::create([
            'surat_keluar_id' => $surat->id,
            'reviewer_id'     => Auth::id(),
            'keputusan'       => $request->keputusan,
            'catatan'         => $request->catatan,
            'reviewed_at'     => now(),
        ]);

        $label = $request->keputusan === 'ditolak' ? 'menolak' : 'meminta revisi pada';

        LogHelper::catat(
            $request->keputusan, 'surat_keluar',
            Auth::user()->name . " $label surat keluar: " . $surat->nomor_surat,
            $surat->id
        );

        return redirect()
            ->route('surat-keluar.show', $id)
            ->with('success', 'Keputusan berhasil disimpan.');
    }

    // ══════════════════════════════════════════════════════════
    // TRACKING – Lacak status surat keluar by nomor surat
    // GET /tracking
    // ══════════════════════════════════════════════════════════
    public function tracking(Request $request)
    {
        $surat   = null;
        $reviews = collect();

        if ($request->filled('nomor_surat')) {
            $surat = SuratKeluar::with(['user', 'approvedBy', 'reviews.reviewer'])
                ->where('nomor_surat', $request->nomor_surat)
                ->first();

            if ($surat) {
                $reviews = $surat->reviews()->with('reviewer')->oldest('reviewed_at')->get();
            }
        }

        return view('tracking.index', compact('surat', 'reviews'));
    }
}