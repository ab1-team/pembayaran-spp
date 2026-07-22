<?php

namespace App\Http\Controllers;

use App\Models\Jenis_Biaya;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->boolean('gen_piutang')) {
            $job = (string) $request->query('job', '');
            $tokenKey = 'piutang_token_' . $job;
            if ($job && session()->has($tokenKey)) {
                session()->forget($tokenKey);
            } else {
                return redirect()->route('app.dashboard');
            }
        }

        $today       = Carbon::today();
        $bulanAwal   = Carbon::now()->startOfMonth();
        $bulanAkhir  = Carbon::now()->endOfMonth();

        $siswaCount    = Siswa::count();
        $siswaAktif    = Siswa::aktif()->count();
        $siswaNonAktif = Siswa::nonAktif()->count();
        $siswaBlokir   = Siswa::blokir()->count();
        $jenis_biaya   = Jenis_Biaya::whereHas('get_jenis_pembayaran', fn($q) => $q->where('nama', 'like', '%SPP%'))
            ->orderBy('angkatan', 'desc')
            ->get();

        $pemasukanHariIni = (float) Transaksi::whereDate('tanggal_transaksi', $today)
            ->where('rekening_debit', 'like', '1.1.01.%')
            ->whereNull('deleted_at')
            ->sum('jumlah');

        $pemasukanBulanIni = (float) Transaksi::whereBetween('tanggal_transaksi', [$bulanAwal, $bulanAkhir])
            ->where('rekening_debit', 'like', '1.1.01.%')
            ->whereNull('deleted_at')
            ->sum('jumlah');

        [$tunggakanSpp, $totalTunggakanSpp, $jumlahSiswaMenunggak] = $this->hitungTunggakanSpp();

        $labelsBulanan = [];
        $pendapatanBulanan = [];
        $from = Carbon::now()->subMonths(11)->startOfMonth();
        $to = Carbon::now()->endOfMonth();
        $bulananRaw = Transaksi::whereBetween('tanggal_transaksi', [$from, $to])
            ->where('rekening_debit', 'like', '1.1.01.%')
            ->whereNull('deleted_at')
            ->selectRaw('YEAR(tanggal_transaksi) y, MONTH(tanggal_transaksi) m, SUM(jumlah) total')
            ->groupBy('y', 'm')
            ->get()
            ->keyBy(fn ($r) => $r->y . '-' . str_pad((string) $r->m, 2, '0', STR_PAD_LEFT))
            ->map(fn ($r) => (float) $r->total)
            ->all();
        for ($i = 11; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i);
            $labelsBulanan[] = $m->translatedFormat('M y');
            $key = $m->format('Y-m');
            $pendapatanBulanan[] = $bulananRaw[$key] ?? 0.0;
        }
        unset($from, $to, $bulananRaw);

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
            'siswaCount',
            'siswaAktif',
            'siswaNonAktif',
            'siswaBlokir',
            'jenis_biaya',
            'pemasukanHariIni',
            'pemasukanBulanIni',
            'tunggakanSpp',
            'totalTunggakanSpp',
            'jumlahSiswaMenunggak',
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
        [$rows] = $this->hitungTunggakanSpp();

        return view('dashboard.partials.siswa-menunggak', ['rows' => $rows]);
    }

    private function hitungTunggakanSpp(): array
    {
        $now = Carbon::now();
        $tahunIni = (int) $now->format('Y');
        $bulanIni = (int) $now->format('m');

        $tunggakanRows = DB::table('anggota_kelas as ak')
            ->join('spp', 'spp.anggota_kelas', '=', 'ak.id')
            ->join('siswa', 'siswa.id', '=', 'ak.id_siswa')
            ->where('ak.status', 'aktif')
            ->where('spp.status', 'B')
            ->where(function ($q) use ($tahunIni, $bulanIni) {
                $q->whereYear('spp.tanggal', '<', $tahunIni)
                    ->orWhere(function ($q2) use ($tahunIni, $bulanIni) {
                        $q2->whereYear('spp.tanggal', $tahunIni)
                            ->whereMonth('spp.tanggal', '<', $bulanIni);
                    });
            })
            ->orderBy('siswa.nama')
            ->orderBy('spp.tanggal')
            ->get([
                'ak.id as ak_id',
                'ak.id_siswa',
                'siswa.nisn',
                'siswa.nama',
                'siswa.kode_kelas',
                'siswa.spp_nominal',
                'spp.tanggal',
                'spp.nominal as spp_nominal_row',
            ]);

        $grouped = [];
        foreach ($tunggakanRows as $r) {
            $key = $r->id_siswa;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'id_siswa' => $r->id_siswa,
                    'nisn' => $r->nisn,
                    'nama' => $r->nama,
                    'kode_kelas' => $r->kode_kelas,
                    'spp_nominal' => $r->spp_nominal,
                    'bulan_tunggakan' => [],
                    'spp_nominal_row' => $r->spp_nominal_row,
                ];
            }
            $grouped[$key]['bulan_tunggakan'][] = Carbon::parse($r->tanggal)->startOfMonth();
        }

        $rows = collect($grouped)->map(function ($g) {
            $bulanTunggakan = collect($g['bulan_tunggakan'])->unique(fn ($d) => $d->format('Y-m'))->sortBy->timestamp->values();
            $jumlahBulan = $bulanTunggakan->count();
            $nominalPerBulan = (float) ($g['spp_nominal'] ?? $g['spp_nominal_row'] ?? 0);

            return (object) [
                'siswa' => (object) ['nisn' => $g['nisn'], 'nama' => $g['nama']],
                'kode_kelas' => $g['kode_kelas'],
                'jumlah_bulan' => $jumlahBulan,
                'nominal_per_bulan' => $nominalPerBulan,
                'total_tunggakan' => $nominalPerBulan * $jumlahBulan,
                'bulan_tunggakan' => $bulanTunggakan,
            ];
        })->values();

        $total = (float) $rows->sum('total_tunggakan');

        return [$rows, $total, $rows->count()];
    }
}
