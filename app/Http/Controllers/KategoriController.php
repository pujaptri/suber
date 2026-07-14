<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    // INDEX - List categories with search & pagination
    public function index(Request $request)
    {
        $query = Kategori::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama', 'like', "%$s%")
                  ->orWhere('kode', 'like', "%$s%")
                  ->orWhere('deskripsi', 'like', "%$s%");
            });
        }

        $kategoriList = $query->paginate(10)->withQueryString();

        return view('kategori.index', compact('kategoriList'));
    }

    // CREATE - Show create form
    public function create()
    {
        return view('kategori.create');
    }

    // STORE - Save a new category
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'required|string|max:50|unique:kategori,kode',
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'kode.unique' => 'Kode kategori sudah terdaftar di sistem.',
        ]);

        $kategori = Kategori::create($validated);

        LogHelper::catat(
            'tambah', 'kategori',
            Auth::user()->name . ' membuat kategori: ' . $kategori->nama,
            $kategori->id
        );

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori ' . $kategori->nama . ' berhasil ditambahkan.');
    }

    // SHOW - View details of a category
    public function show(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.show', compact('kategori'));
    }

    // EDIT - Show edit form
    public function edit(string $id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.edit', compact('kategori'));
    }

    // UPDATE - Save updated category details
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama'      => 'required|string|max:100',
            'kode'      => 'required|string|max:50|unique:kategori,kode,' . $id,
            'deskripsi' => 'nullable|string|max:1000',
        ], [
            'kode.unique' => 'Kode kategori sudah digunakan oleh kategori lain.',
        ]);

        $kategori->update($validated);

        LogHelper::catat(
            'edit', 'kategori',
            Auth::user()->name . ' memperbarui kategori: ' . $kategori->nama,
            $kategori->id
        );

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data Kategori Berhasil Diperbarui.');
    }

    // DESTROY - Delete category (soft delete)
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        $nama = $kategori->nama;

        $kategori->delete();

        LogHelper::catat(
            'hapus', 'kategori',
            Auth::user()->name . ' menghapus kategori: ' . $nama,
            $id
        );

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Data Kategori Berhasil Dihapus.');
    }
}
