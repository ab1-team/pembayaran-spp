<?php

namespace App\Http\Controllers;

use App\Models\Anggota_Kelas;
use App\Models\Jenis_Biaya;
use App\Models\JenisPembayaran;
use App\Models\Rekening;
use App\Models\Siswa;
use App\Models\Tahun_Akademik;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function CariSiswaAktif(Request $request)
    {
        $params = $request->input('query');

        $results = Siswa::query()
            ->Aktif()
            ->where(function ($q) use ($params) {
                $q->where('nama', 'LIKE', "%{$params}%")
                    ->orWhere('nisn', 'LIKE', "%{$params}%");
            })
            ->orderBy('nama')
            ->limit(20)
            ->get(['id', 'nama', 'nisn', 'kode_kelas'])
            ->map(fn ($s) => [
                'id_siswa' => $s->id,
                'nama' => $s->nama,
                'nisn' => $s->nisn,
                'kode_kelas' => $s->kode_kelas,
                'package_inisial' => null,
            ]);

        return response()->json($results);
    }

    public function spp($id)
    {
        $kodePiutangSpp = JenisPembayaran::KODE_PIUTANG_DEFAULT;

        if ((string) $id === '0') {
            $siswa = new Siswa;
            $spp = collect();
            $spp_perbulan = 0;
            $target_bulan = 0;
            $sd_bulan_ini = 0;
            $sumber_dana = collect();
            $tahun_angkatan = '';
            $jenis_biaya = collect();
            $nominalMap = collect();
            $kode_tunggakan = collect();
        } else {
            $anggota_kelas = Anggota_Kelas::where('id_siswa', $id)
                ->with([
                    'getSiswa',
                    'getSpp',
                ])->where('status', 'aktif')
                ->first();

            if (! $anggota_kelas) {
                return response()->json([
                    'success' => false,
                    'view' => '<div class="text-center py-5">'
                        . '<i class="bi bi-exclamation-triangle text-danger fs-1"></i>'
                        . '<h6 class="mt-2 mb-1">Siswa belum bisa dimuat</h6>'
                        . '<div class="small text-muted mx-auto" style="max-width:380px;">'
                        . 'Data siswa ditemukan, tetapi <strong>belum memiliki Anggota Kelas ber-status Aktif</strong>.'
                        . '<div class="mt-2"><strong>Penyebab:</strong> siswa tidak terdaftar di kelas aktif periode ini (nonaktif / pindah / belum dialokasikan).</div>'
                        . '<div class="mt-2"><strong>Solusi:</strong> buka menu <em>Kelas &rarr; Anggota Kelas</em>, tambahkan siswa ke kelas dengan status <em>Aktif</em>, lalu muat ulang halaman.</div>'
                        . '</div></div>',
                ]);
            }

            $siswa = $anggota_kelas->getSiswa;
            $spp = $anggota_kelas->getSpp;
            $spp_perbulan = $siswa->spp_nominal;
            $target_bulan = $spp->sum('nominal');
            $sd_bulan_ini = $spp->where('status', 'L')->sum('nominal');
            $sumber_dana = Rekening::where('kode_akun', 'like', '1.1.01.%')->get();
            $tahun_angkatan = Tahun_Akademik::where('status', 'aktif')->value('nama_tahun') ?? date('Y');
            $jenis_biaya = JenisPembayaran::orderBy('nama')->get();
            $nominalMap = Jenis_Biaya::where('angkatan', (string) $tahun_angkatan)
                ->get()
                ->groupBy(fn ($i) => $i->id_jp.'|'.$i->angkatan);
            $sppJP = $jenis_biaya->first(fn ($jp) => $jp->isSpp());
            $kodeAkunSpp = $sppJP->kode_akun ?? '';
            $kode_tunggakan = $kodeAkunSpp
                ? Transaksi::where('rekening_debit', $kodePiutangSpp)
                    ->where('rekening_kredit', $kodeAkunSpp)
                    ->where('siswa_id', $siswa->id)
                    ->orderBy('tanggal_transaksi')->where('deleted_at', null)
                    ->get()
                : collect();
        }

        return response()->json([
            'success' => true,
            'view' => view('transaksi.map_arsip.form_spp')
                ->with([
                    'siswa' => $siswa,
                    'spp' => $spp,
                    'spp_perbulan' => $spp_perbulan,
                    'target_bulan' => $target_bulan,
                    'sd_bulan_ini' => $sd_bulan_ini,
                    'sumber_dana' => $sumber_dana,
                    'jenis_biaya' => $jenis_biaya,
                    'tahun_angkatan' => $tahun_angkatan,
                    'nominalMap' => $nominalMap,
                    'kode_tunggakan' => $kode_tunggakan,
                    'kode_piutang_spp' => $kodePiutangSpp,
                ])
                ->render(),
        ]);
    }
}
