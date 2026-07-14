<?php
// ============================================================
// LOKASI FILE : app/Http/Controllers/PenggunaController.php
// CARA BUAT   : php artisan make:controller PenggunaController
// Hanya bisa diakses oleh SuperAdmin (middleware role:superadmin)
// ============================================================

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // ── Daftar semua pengguna ──
    public function index(Request $request)
    {
        $query = User::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name',  'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $pengguna = $query->paginate(10)->withQueryString();

        return view('pengguna.index', compact('pengguna'));
    }

    // ── Form tambah pengguna ──
    public function create()
    {
        return view('pengguna.create');
    }

    // ── Simpan pengguna baru ──
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
            'role'                  => 'required|in:admin,superadmin',
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
            'email.unique'       => 'Email sudah digunakan oleh pengguna lain.',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'role'      => $validated['role'],
            'is_active' => true,
        ]);

        LogHelper::catat(
            'tambah', 'pengguna',
            Auth::user()->name . ' menambahkan pengguna: ' . $user->email . ' (' . $user->role . ')',
            $user->id
        );

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna ' . $user->name . ' berhasil ditambahkan.');
    }

    // ── Form edit pengguna ──
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('pengguna.index')
                ->with('error', 'Gunakan halaman profil untuk mengubah data Anda sendiri.');
        }

        return view('pengguna.edit', compact('user'));
    }

    // ── Simpan perubahan data pengguna ──
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:admin,superadmin',
        ];

        // Password hanya divalidasi kalau diisi
        if ($request->filled('password')) {
            $rules['password'] = 'min:8|confirmed';
        }

        $request->validate($rules, [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        LogHelper::catat(
            'edit', 'pengguna',
            Auth::user()->name . ' mengubah data pengguna: ' . $user->email,
            $user->id
        );

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // ── Hapus pengguna ──
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('pengguna.index')
                ->with('error', 'Tidak dapat menghapus akun yang sedang aktif.');
        }

        $email = $user->email;
        $user->delete();

        LogHelper::catat(
            'hapus', 'pengguna',
            Auth::user()->name . ' menghapus pengguna: ' . $email,
            $id
        );

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    // ── Aktifkan / Nonaktifkan pengguna ──
    public function toggleAktif(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('pengguna.index')
                ->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        LogHelper::catat(
            'toggle_aktif', 'pengguna',
            Auth::user()->name . " $status akun: " . $user->email,
            $user->id
        );

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Akun pengguna berhasil ' . $status . '.');
    }
}