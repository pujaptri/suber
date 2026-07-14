<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class SuratMasukController extends Controller
{
    // =========================================================
    // INDEX – list + search + filter
    // =========================================================
    public function index(Request $request)
    {
        $query = SuratMasuk::with('user')->latest('tanggal_diterima');

        if ($request->filled('search')) {
            $query->where('nomor_surat', 'like', "%{$request->search}%")
                  ->orWhere('perihal', 'like', "%{$request->search}%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('sifat_surat')) {
            $query->where('sifat_surat', $request->sifat_surat);
        }

        $suratMasuk = $query->paginate(10);

        return view('surat-masuk.index', compact('suratMasuk'));
    }

    // =========================================================
    // CREATE
    // =========================================================
    public function create()
    {
        return view('surat-masuk.create');
    }

    // =========================================================
    // STORE
    // =========================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_surat'      => 'required|unique:surat_masuk',
            'asal_surat'       => 'required',
            'tanggal_diterima' => 'required|date',
            'tanggal_surat'    => 'required|date',
            'perihal'          => 'nullable|string|max:500',
            'kategori'         => 'required',
            'sifat_surat'      => 'required',
            'penerima'         => 'required|string|max:255',
            'bagian'           => 'required|string|max:255',
            'lampiran'         => 'required|file|mimes:pdf,docx,doc,xls,xlsx|max:5120',
        ], [
            'lampiran.required' => 'Lampiran wajib diunggah.',
        ]);

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['lampiran'] = $file->storeAs('surat-masuk', $filename, 'public');
        }

        $validated['user_id'] = Auth::id();

        $surat = SuratMasuk::create($validated);

        LogHelper::catat(
            'CREATE',
            'Surat Masuk',
            Auth::user()->name . ' menambah surat: ' . $surat->nomor_surat,
            $surat->id
        );

        return redirect()->route('surat-masuk.index')->with('success', 'Data surat masuk berhasil ditambahkan');
    }

    // =========================================================
    // SHOW
    // =========================================================
    public function show($id)
    {
        $surat = SuratMasuk::with('user')->findOrFail($id);
        return view('surat-masuk.show', compact('surat'));
    }

    // =========================================================
    // EDIT
    // =========================================================
    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('surat-masuk.edit', compact('surat'));
    }

    // =========================================================
    // UPDATE
    // =========================================================
    public function update(Request $request, $id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $hasExistingLampiran = $surat->lampiran && ($request->input('hapus_lampiran') !== '1');

        $rules = [
            'nomor_surat'      => 'required|unique:surat_masuk,nomor_surat,' . $id,
            'asal_surat'       => 'required',
            'tanggal_diterima' => 'required|date',
            'tanggal_surat'    => 'required|date',
            'perihal'          => 'nullable|string|max:500',
            'kategori'         => 'required',
            'sifat_surat'      => 'required',
            'penerima'         => 'required|string|max:255',
            'bagian'           => 'required|string|max:255',
        ];

        if ($hasExistingLampiran) {
            $rules['lampiran'] = 'nullable|file|mimes:pdf,docx,doc,xls,xlsx|max:5120';
        } else {
            $rules['lampiran'] = 'required|file|mimes:pdf,docx,doc,xls,xlsx|max:5120';
        }

        $validated = $request->validate($rules, [
            'lampiran.required' => 'Lampiran wajib diunggah.',
        ]);

        if ($request->hasFile('lampiran')) {
            if ($surat->lampiran && Storage::disk('public')->exists($surat->lampiran)) {
                Storage::disk('public')->delete($surat->lampiran);
            }

            $file = $request->file('lampiran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['lampiran'] = $file->storeAs('surat-masuk', $filename, 'public');
        } elseif ($request->input('hapus_lampiran') == '1') {
            if ($surat->lampiran && Storage::disk('public')->exists($surat->lampiran)) {
                Storage::disk('public')->delete($surat->lampiran);
            }
            $validated['lampiran'] = null;
        }

        $surat->update($validated);

        LogHelper::catat(
            'UPDATE',
            'Surat Masuk',
            Auth::user()->name . ' update surat: ' . $surat->nomor_surat,
            $surat->id
        );

        return redirect()->route('surat-masuk.show', $id)->with('success', 'Data Surat Masuk Berhasil Diperbarui');
    }

    // =========================================================
    // DELETE
    // =========================================================
    public function destroy($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if ($surat->lampiran) {
            Storage::disk('public')->delete($surat->lampiran);
        }

        LogHelper::catat(
            'DELETE',
            'Surat Masuk',
            Auth::user()->name . ' hapus surat: ' . $surat->nomor_surat,
            $id
        );

        $surat->delete();

        return redirect()->route('surat-masuk.index')->with('success', 'Data Surat Masuk Berhasil Dihapus');
    }
}