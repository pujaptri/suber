<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogAktivitas;
use App\Models\User;
use Carbon\Carbon;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->latest('waktu_aktivitas');

        // Cari berdasarkan deskripsi atau nama pengguna
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('deskripsi', 'like', "%$s%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%$s%"));
            });
        }

        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        if ($request->filled('jenis_aksi')) {
            $query->where('jenis_aksi', $request->jenis_aksi);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter Rentang Waktu (Quick Filters)
        if ($request->filled('filter_period')) {
            $period = $request->filter_period;
            if ($period === 'harian') {
                $query->whereDate('waktu_aktivitas', Carbon::today()->toDateString());
            } elseif ($period === 'mingguan') {
                $query->whereBetween('waktu_aktivitas', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($period === 'bulanan') {
                $query->whereBetween('waktu_aktivitas', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }
        } else {
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('waktu_aktivitas', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('waktu_aktivitas', '<=', $request->tanggal_sampai);
            }
        }

        $logs = $query->paginate(15)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('log-aktivitas.index', compact('logs', 'users'));
    }

    public function ekspor(Request $request)
    {
        $query = LogAktivitas::with('user')->latest('waktu_aktivitas');

        // Cari berdasarkan deskripsi atau nama pengguna
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('deskripsi', 'like', "%$s%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%$s%"));
            });
        }

        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        if ($request->filled('jenis_aksi')) {
            $query->where('jenis_aksi', $request->jenis_aksi);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter Rentang Waktu (Quick Filters)
        if ($request->filled('filter_period')) {
            $period = $request->filter_period;
            if ($period === 'harian') {
                $query->whereDate('waktu_aktivitas', Carbon::today()->toDateString());
            } elseif ($period === 'mingguan') {
                $query->whereBetween('waktu_aktivitas', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($period === 'bulanan') {
                $query->whereBetween('waktu_aktivitas', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            }
        } else {
            if ($request->filled('tanggal_dari')) {
                $query->whereDate('waktu_aktivitas', '>=', $request->tanggal_dari);
            }
            if ($request->filled('tanggal_sampai')) {
                $query->whereDate('waktu_aktivitas', '<=', $request->tanggal_sampai);
            }
        }

        $logs = $query->get();

        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename=log_aktivitas_' . now()->format('Ymd_His') . '.csv',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $columns = ['Waktu / Tanggal', 'ID Aktivitas', 'User', 'Aksi', 'Modul', 'Deskripsi', 'IP Address'];

        $callback = function () use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM for UTF-8
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->waktu_aktivitas->locale('id')->isoFormat('D MMMM Y, HH:mm:ss'),
                    'LOG-' . str_pad($log->id, 6, '0', STR_PAD_LEFT),
                    $log->user->name ?? '-',
                    strtoupper($log->jenis_aksi),
                    strtoupper($log->modul),
                    $log->deskripsi,
                    $log->ip_address ?? '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}