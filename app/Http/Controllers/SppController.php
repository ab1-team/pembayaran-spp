<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use App\Models\Siswa;
use App\Models\Rekening;
use App\Models\JenisPembayaran;
use App\Models\Jenis_Biaya;
use App\Models\Anggota_Kelas;
use App\Models\Transaksi;
use App\Models\Tahun_akademik;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Utils\Tanggal;

class SppController extends Controller
{

    public function CariSiswaAktif(Request $request)
    {
        $params = $request->input('query');

        $results = Siswa::query()
            ->where(function ($q) use ($params) {
                $q->where('nama', 'LIKE', "%{$params}%")
                    ->orWhere('nisn', 'LIKE', "%{$params}%");
            })
            ->orderBy('nama')
            ->limit(20)
            ->get(['id', 'nama', 'nisn', 'kode_kelas'])
            ->map(fn ($s) => [
                'id_siswa'         => $s->id,
                'nama'             => $s->nama,
                'nisn'             => $s->nisn,
                'kode_kelas'       => $s->kode_kelas,
                'package_inisial'  => null,
            ]);

        return response()->json($results);
    }

    public function spp($id)
    {
        $anggota_kelas = Anggota_Kelas::where('id_siswa', $id)
            ->with([
                'getSiswa',
                'getSpp',
            ])->where('status', 'aktif')
            ->first();

        if (!$anggota_kelas) {
            return response()->json([
                'success' => false,
                'view' => '<div class="text-center text-muted py-3">Data siswa tidak ditemukan</div>'
            ]);
        }

        $spp_perbulan = $anggota_kelas->getSiswa->spp_nominal;
        $target_bulan = $anggota_kelas->getSpp->sum('nominal');
        $sd_bulan_ini = $anggota_kelas->getSpp->where('status', 'L')->sum('nominal');
        $sumber_dana = Rekening::where('kode_akun', 'like', '1.1.01.%')->get();
        $tahun_angkatan = Tahun_akademik::where('status', 'aktif')->value('nama_tahun') ?? date('Y');
        $jenis_biaya = JenisPembayaran::orderBy('nama')->get();
        $nominalMap = Jenis_Biaya::where('angkatan', (string) $tahun_angkatan)
            ->get()
            ->groupBy(fn($i) => $i->id_jp . '|' . $i->angkatan);
        $sppJP = $jenis_biaya->first(fn($jp) => $jp->isSpp());
        $kodeAkunSpp = $sppJP->kode_akun ?? '';
        $kodePiutangSpp = JenisPembayaran::KODE_PIUTANG_DEFAULT;
        $kode_tunggakan = $kodeAkunSpp
            ? Transaksi::where('rekening_debit', $kodePiutangSpp)
                ->where('rekening_kredit', $kodeAkunSpp)
                ->where('siswa_id', $anggota_kelas->getSiswa->id)
                ->orderBy('tanggal_transaksi')->where('deleted_at', null)
                ->get()
            : collect();

        return response()->json([
            'success' => true,
            'view' => view('transaksi.map_arsip.form_spp')
                ->with([
                    'siswa'         => $anggota_kelas->getSiswa,
                    'spp'           => $anggota_kelas->getSpp,
                    'spp_perbulan'  => $spp_perbulan,
                    'target_bulan'  => $target_bulan,
                    'sd_bulan_ini'  => $sd_bulan_ini,
                    'sumber_dana'   => $sumber_dana,
                    'jenis_biaya'   => $jenis_biaya,
                    'tahun_angkatan' => $tahun_angkatan,
                    'nominalMap'    => $nominalMap,
                    'kode_tunggakan' => $kode_tunggakan,
                    'kode_piutang_spp' => $kodePiutangSpp,
                ])
                ->render(),
        ]);
    }
}
