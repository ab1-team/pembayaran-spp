<?php

namespace App\Http\Controllers;

use App\Models\Jenis_Biaya;
use App\Models\Siswa;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today       = Carbon::today();
        $bulanAwal   = Carbon::now()->startOfMonth();
        $bulanAkhir  = Carbon::now()->endOfMonth();

        $siswa         = Siswa::all();
        $siswaCount    = Siswa::count();
        $siswaAktif    = Siswa::aktif()->count();
        $siswaNonAktif = Siswa::nonAktif()->count();
        $siswaBlokir   = Siswa::blokir()->count();
        $jenis_biaya   = Jenis_Biaya::orderBy('angkatan', 'desc')->get();

        $pemasukanHariIni = (float) Transaksi::whereDate('tanggal_transaksi', $today)
            ->where('rekening_debit', 'like', '1.1.01.%')
            ->whereNull('deleted_at')
            ->sum('jumlah');

        $pemasukanBulanIni = (float) Transaksi::whereBetween('tanggal_transaksi', [$bulanAwal, $bulanAkhir])
            ->where('rekening_debit', 'like', '1.1.01.%')
            ->whereNull('deleted_at')
            ->sum('jumlah');

        $tunggakan = Siswa::aktif()
            ->with(['getTransaksi' => function ($q) {
                $q->where('rekening_debit', '1.1.03.01')
                    ->where('rekening_kredit', '4.1.01.01')
                    ->whereNull('deleted_at')
                    ->with('spp');
            }])
            ->whereHas('getTransaksi', function ($q) {
                $q->where('rekening_debit', '1.1.03.01')
                    ->where('rekening_kredit', '4.1.01.01')
                    ->whereNull('deleted_at');
            })
            ->get();

        $totalTunggakan = (float) $tunggakan->reduce(
            fn($c, $s) => $c + (float) $s->getTransaksi->sum('jumlah'),
            0
        );

        $labelsBulanan = [];
        $pendapatanBulanan = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $labelsBulanan[] = $m->translatedFormat('M y');
            $pendapatanBulanan[] = (float) Transaksi::whereYear('tanggal_transaksi', $m->year)
                ->whereMonth('tanggal_transaksi', $m->month)
                ->where('rekening_debit', 'like', '1.1.01.%')
                ->whereNull('deleted_at')
                ->sum('jumlah');
        }

        $recentTransaksi = Transaksi::with(['siswa', 'user'])
            ->whereNull('deleted_at')
            ->when($request->filled('search'), function ($q) use ($request) {
                $term = '%' . $request->search . '%';
                $q->where(function ($w) use ($term) {
                    $w->where('keterangan', 'like', $term)
                      ->orWhereHas('siswa', function ($s) use ($term) {
                          $s->where('nama', 'like', $term)
                            ->orWhere('nisn', 'like', $term);
                      });
                });
            })
            ->orderByDesc('tanggal_transaksi')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $title = 'Dashboard';

        return view('dashboard.index', compact(
            'title',
            'siswa',
            'siswaCount',
            'siswaAktif',
            'siswaNonAktif',
            'siswaBlokir',
            'jenis_biaya',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'tunggakan',
            'totalTunggakan',
            'labelsBulanan',
            'pendapatanBulanan',
            'recentTransaksi'
        ));
    }

    public function siswaAktifTable()
    {
        $rows = Siswa::aktif()->orderBy('nama')->get();
        return view('dashboard.partials.siswa-aktif', ['rows' => $rows]);
    }

    public function siswaMenunggakTable()
    {
        $rows = Siswa::aktif()
            ->with(['getTransaksi' => function ($q) {
                $q->where('rekening_debit', '1.1.03.01')
                    ->where('rekening_kredit', '4.1.01.01')
                    ->whereNull('deleted_at')
                    ->with('spp');
            }])
            ->whereHas('getTransaksi', function ($q) {
                $q->where('rekening_debit', '1.1.03.01')
                    ->where('rekening_kredit', '4.1.01.01')
                    ->whereNull('deleted_at');
            })
            ->orderBy('nama')
            ->get();

        return view('dashboard.partials.siswa-menunggak', ['rows' => $rows]);
    }
}
