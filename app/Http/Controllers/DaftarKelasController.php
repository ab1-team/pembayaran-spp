<?php

namespace App\Http\Controllers;

use App\Models\Anggota_Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Tahun_Akademik;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DaftarKelasController extends Controller
{
    public function index()
    {
        $tahunBerjalan = $this->tahunBerjalan();

        return view('daftar-kelas.index', [
            'title'          => 'Daftar Kelas',
            'tahunBerjalan'  => $tahunBerjalan,
        ]);
    }

    private function tahunBerjalan(): ?string
    {
        $now = \Carbon\Carbon::now();
        $yy  = (int) $now->format('Y');
        $mm  = (int) $now->format('n');

        if ($mm >= 7) {
            $candidate = sprintf('%d/%d', $yy, $yy + 1);
        } else {
            $candidate = sprintf('%d/%d', $yy - 1, $yy);
        }

        $found = Tahun_Akademik::where('nama_tahun', $candidate)->value('nama_tahun');
        if ($found) {
            return $found;
        }

        return Tahun_Akademik::orderByDesc('nama_tahun')->value('nama_tahun');
    }

    public function listTahun(Request $request)
    {
        $search = $request->get('q');

        $query = Tahun_Akademik::select('id', 'nama_tahun')
            ->orderBy('nama_tahun');
        if ($search) {
            $query->where('nama_tahun', 'like', "%{$search}%");
        }

        return response()->json(
            $query->get()->map(fn($item) => [
                'id'         => $item->id,
                'nama_tahun' => $item->nama_tahun,
            ])
        );
    }

    public function listKelas(Request $request)
    {
        $search = $request->get('q');

        $query = Kelas::select('id', 'nama_kelas', 'kode_kelas', 'tingkat');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_kelas', 'like', "%{$search}%")
                    ->orWhere('nama_kelas', 'like', "%{$search}%")
                    ->orWhere('tingkat', 'like', "%{$search}%");
            });
        }

        return response()->json(
            $query->get()->map(fn($item) => [
                'id'         => $item->id,
                'nama_kelas' => $item->nama_kelas,
                'kode_kelas' => $item->kode_kelas,
                'tingkat'    => $item->tingkat,
            ])
        );
    }

    public function data(Request $request)
    {
        $ta    = $request->tahun_akademik;
        $kelas = $request->kelas;
        if ($kelas === '__all__') {
            $kelas = null;
        }

        $query = Siswa::query()
            ->whereHas('anggotaKelas', function ($q) use ($ta, $kelas) {
                $q->where('status', 'aktif');
                if ($ta)    $q->where('tahun_akademik', $ta);
                if ($kelas) $q->where('kode_kelas', $kelas);
            })
            ->with(['anggotaKelas' => function ($q) use ($ta, $kelas) {
                $q->where('status', 'aktif');
                if ($ta)    $q->where('tahun_akademik', $ta);
                if ($kelas) $q->where('kode_kelas', $kelas);
                $q->orderByDesc('id');
            }, 'anggotaKelas.spp']);

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('nisn', function ($row) {
                return $row->nisn;
            })
            ->addColumn('nama', function ($row) {
                return $row->nama;
            })
            ->addColumn('spp_per_bulan', function ($row) {
                $nominal = (int) ($row->spp_nominal ?? 0);
                return $nominal;
            })
            ->addColumn('target_sampai_bulan_ini', function ($row) {
                $ak = $row->anggotaKelas->first();
                if (!$ak) return 0;
                $bulanSekarang = (int) date('n');
                $tahunSekarang = (int) date('Y');
                return $ak->spp
                    ->filter(function ($s) use ($bulanSekarang, $tahunSekarang) {
                        if (!$s->tanggal) return false;
                        $ts = $s->tanggal instanceof \DateTimeInterface
                            ? $s->tanggal
                            : \Carbon\Carbon::parse($s->tanggal);
                        return (int) $ts->format('Y') < $tahunSekarang
                            || ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                    })
                    ->sum('nominal');
            })
            ->addColumn('realisasi_sampai_bulan_ini', function ($row) {
                $ak = $row->anggotaKelas->first();
                if (!$ak) return 0;
                $bulanSekarang = (int) date('n');
                $tahunSekarang = (int) date('Y');
                return $ak->spp
                    ->where('status', 'L')
                    ->filter(function ($s) use ($bulanSekarang, $tahunSekarang) {
                        if (!$s->tgl_lunas) {
                            if (!$s->tanggal) return false;
                            $ts = $s->tanggal instanceof \DateTimeInterface
                                ? $s->tanggal
                                : \Carbon\Carbon::parse($s->tanggal);
                            return (int) $ts->format('Y') < $tahunSekarang
                                || ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                        }
                        $ts = $s->tgl_lunas instanceof \DateTimeInterface
                            ? $s->tgl_lunas
                            : \Carbon\Carbon::parse($s->tgl_lunas);
                        return (int) $ts->format('Y') < $tahunSekarang
                            || ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                    })
                    ->sum('nominal');
            })
            ->addColumn('status_tagihan', function ($row) {
                $ak = $row->anggotaKelas->first();
                if (!$ak) return 'menunggak';
                $bulanSekarang = (int) date('n');
                $tahunSekarang = (int) date('Y');
                $target = $ak->spp
                    ->filter(function ($s) use ($bulanSekarang, $tahunSekarang) {
                        if (!$s->tanggal) return false;
                        $ts = $s->tanggal instanceof \DateTimeInterface
                            ? $s->tanggal
                            : \Carbon\Carbon::parse($s->tanggal);
                        return (int) $ts->format('Y') < $tahunSekarang
                            || ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                    })
                    ->sum('nominal');
                $realisasi = $ak->spp
                    ->where('status', 'L')
                    ->filter(function ($s) use ($bulanSekarang, $tahunSekarang) {
                        if (!$s->tgl_lunas) {
                            if (!$s->tanggal) return false;
                            $ts = $s->tanggal instanceof \DateTimeInterface
                                ? $s->tanggal
                                : \Carbon\Carbon::parse($s->tanggal);
                            return (int) $ts->format('Y') < $tahunSekarang
                                || ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                        }
                        $ts = $s->tgl_lunas instanceof \DateTimeInterface
                            ? $s->tgl_lunas
                            : \Carbon\Carbon::parse($s->tgl_lunas);
                        return (int) $ts->format('Y') < $tahunSekarang
                            || ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                    })
                    ->sum('nominal');
                if ($realisasi > $target) return 'lebih';
                if ($realisasi == $target && $target > 0) return 'pas';
                return 'menunggak';
            })
            ->addColumn('target_daftar_ulang', function ($row) {
                return 0;
            })
            ->addColumn('realisasi_daftar_ulang', function ($row) {
                return 0;
            })
            ->addColumn('action', function ($row) use ($request) {
                $params = [
                    'prefill_id'       => $row->id,
                    'prefill_nama'     => $row->nama,
                    'prefill_status'   => 'aktif',
                    'prefill_jenis'    => 'spp',
                    'tahun_akademik'   => $request->tahun_akademik,
                ];
                $url = '/app/Transaksi/pembayaran-spp?' . http_build_query($params);
                return '<a href="' . $url . '" class="btn btn-info btn-sm text-white d-inline-flex align-items-center gap-1" title="Bayar Sekarang">'
                    . '<span>Bayar Sekarang</span>'
                    . '<i class="material-icons align-middle" style="font-size:16px">arrow_forward</i>'
                    . '</a>';
            })
            ->rawColumns(['action', 'target_sampai_bulan_ini'])
            ->toJson();
    }
}
