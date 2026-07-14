<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ========================================================
        // STATISTIK UTAMA DASHBOARD
        // ========================================================
        $stats = [
            'total_surat_masuk'  => SuratMasuk::count(),
            'total_surat_keluar' => SuratKeluar::count(),
            'menunggu_ttd'       => SuratKeluar::where('status', 'menunggu_ttd')->count(),
        ];

        // ========================================================
        // SURAT MASUK TERBARU
        // ========================================================
        $suratMasukTerbaru = SuratMasuk::with('user')
            ->latest()
            ->take(5)
            ->get();

        // ========================================================
        // SURAT KELUAR MENUNGGU TTD
        // ========================================================
        $menungguTTD = SuratKeluar::with('user')
            ->where('status', 'menunggu_ttd')
            ->latest()
            ->take(5)
            ->get();

        // ========================================================
        // CHART 6 BULAN TERAKHIR
        // ========================================================
        $chartData = [];

        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);

            $chartData[] = [
                'label'  => $bulan->locale('id')->isoFormat('MMM YY'),
                'masuk'  => SuratMasuk::whereYear('tanggal_diterima', $bulan->year)
                                    ->whereMonth('tanggal_diterima', $bulan->month)
                                    ->count(),
                'keluar' => SuratKeluar::whereYear('tanggal_surat', $bulan->year)
                                    ->whereMonth('tanggal_surat', $bulan->month)
                                    ->count(),
            ];
        }

        // ========================================================
        // LOG AKTIVITAS (ADMIN & SUPERADMIN)
        // ========================================================
        $logTerbaru = ($user->isAdmin() || $user->isSuperAdmin())
            ? LogAktivitas::with('user')
                ->latest('waktu_aktivitas')
                ->take(8)
                ->get()
            : collect();

        return view('dashboard.index', compact(
            'stats',
            'suratMasukTerbaru',
            'menungguTTD',
            'chartData',
            'logTerbaru'
        ));
    }
}