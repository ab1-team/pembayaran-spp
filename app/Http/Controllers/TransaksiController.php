<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Jenis_transaksi;
use App\Models\JenisPembayaran;
use App\Models\Profil;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Inventaris;
use App\Utils\Inventaris as UtilsInventaris;
use App\Utils\Angka;
use App\Utils\Tanggal;
use App\Models\Rekening;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Utils\Keuangan;
use Carbon\Carbon;



class TransaksiController extends Controller
{
    /**
     * Jurnal Umum.
     */
    public function index()
    {
        $title = 'Jurnal Umum';
        $jenisTransaksi = Jenis_transaksi::all();
        $rekening = Rekening::orderBy('kode_akun', 'asc')->get();
        $totalSaldo = (float) Saldo::selectRaw('SUM(debit - kredit) as total')->value('total');

        return view('transaksi.index', compact('title', 'jenisTransaksi', 'rekening', 'totalSaldo'));
    }

    /**
     * Daftar Inventaris Jurnal Umum.
     */
    public function daftarInventaris()
    {
        $tanggal = request()->get('tanggal');
        $jenis = request()->get('jenis');
        $kategori = request()->get('kategori');

        $inventaris = Inventaris::where([
            ['jenis', $jenis],
            ['kategori', intval($kategori)],
            ['tanggal_beli', '<=', $tanggal],
        ])->where(function ($query) {
            $query->where('status', 'baik')->orwhere('status', 'busak');
        })->get();

        $inventarisArray = $inventaris->toArray();
        foreach ($inventaris as $index => $inv) {
            $nilaiBuku = UtilsInventaris::nilaiBuku($tanggal, $inv);

            $inventarisArray[$index]['nilai_buku'] = $nilaiBuku;
        }

        return response()->json($inventarisArray);
    }

    /**
     * Store Jurnal Umum.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'transaksi',
            "tanggal",
            "sumber_dana",
            "disimpan_ke",
            "jurnal_umum",
            "beli_inventaris",
            "hapus_inventaris"
        ]);

        if (!empty($data['sumber_dana'])) {
            $data['sumber_dana'] = explode('. ', $data['sumber_dana'], 2)[0];
        }

        if (!empty($data['disimpan_ke'])) {
            $data['disimpan_ke'] = explode('. ', $data['disimpan_ke'], 2)[0];
        }

        $request->validate([
            'transaksi' => 'required',
            'tanggal' => 'required',
            'sumber_dana' => 'required',
            'disimpan_ke' => 'required',
            'jurnal_umum' => 'required|array',
            'beli_inventaris' => 'required|array',
            'hapus_inventaris' => 'required|array',
        ]);

        $message = "Transaksi berhasil disimpan.";
        $form = $data[$data['transaksi']];
        if ($data['transaksi'] == 'jurnal_umum') {
            $jumlah = Angka::parseInt($form['nominal']);
            Transaksi::create([
                'user_id' => auth()->user()->id,
                'tanggal_transaksi' => $data['tanggal'],
                'rekening_debit' => $data['disimpan_ke'],
                'rekening_kredit' => $data['sumber_dana'],
                'keterangan' => $form['keterangan'],
                'jumlah' => $jumlah,
                'invoice' => 0,
                'kode_spp' => '0',
                'siswa_id' => 0,
                'idtp' => '0',
                'urutan' => '0',
            ]);

            $bulan = (int) Carbon::parse($data['tanggal'])->format('n');
            $tahun = (int) Carbon::parse($data['tanggal'])->format('Y');

            Saldo::firstOrCreate(
                ['kode_akun' => $data['disimpan_ke'], 'bulan' => $bulan, 'tahun' => $tahun],
                ['debit' => 0, 'kredit' => 0]
            )->increment('debit', $jumlah);

            Saldo::firstOrCreate(
                ['kode_akun' => $data['sumber_dana'], 'bulan' => $bulan, 'tahun' => $tahun],
                ['debit' => 0, 'kredit' => 0]
            )->increment('kredit', $jumlah);
        }

        if ($data['transaksi'] == 'beli_inventaris') {
            $jenis_inventaris = $form['jenis_inventaris'];
            $kategori_inventaris = $form['kategori_inventaris'];
            $nama_barang = $form['nama_barang'];
            $harga_satuan = Angka::parseInt($form['harga_satuan']);
            $umur_ekonomis = $form['umur_ekonomis'];
            $jumlah_unit = $form['jumlah_unit'];
            $harga_perolehan = $harga_satuan * $jumlah_unit;

            Inventaris::create([
                'nama' => $nama_barang,
                'tanggal_beli' => $data['tanggal'],
                'tanggal_validasi' => $data['tanggal'],
                'jumlah' => $jumlah_unit,
                'harga_satuan' => $harga_satuan,
                'umur_ekonomis' => $umur_ekonomis,
                'jenis' => $jenis_inventaris,
                'kategori' => $kategori_inventaris,
                'status' => 'baik',
            ]);

            $keterangan = "Beli " . $jumlah_unit . " unit " . $nama_barang;
            Transaksi::create([
                'user_id' => auth()->user()->id,
                'tanggal_transaksi' => $data['tanggal'],
                'rekening_debit' => $data['sumber_dana'],
                'rekening_kredit' => $data['disimpan_ke'],
                'keterangan' => $keterangan,
                'jumlah' => $harga_perolehan,
                'invoice' => 0,
                'kode_spp' => '0',
                'siswa_id' => 0,
                'idtp' => '0',
                'urutan' => '0',
            ]);
        }

        if ($data['transaksi'] == 'hapus_inventaris') {
            $nama_barang = explode('#', $form['daftar_barang']);
            $id_inv = $nama_barang[0];
            $jumlah_barang = $nama_barang[1];
            $status = $form['alasan'];
            $jumlah_unit = $form['jumlah_unit_inventaris'];
            $nilai_buku = Angka::parseInt($form['nilai_buku']);
            $harga_jual = Angka::parseInt($form['harga_jual']);

            $inv = Inventaris::where('id', $id_inv)->first();

            $tanggal_beli = $inv->tanggal_beli;
            $harga_satuan = $inv->harga_satuan;
            $umur_ekonomis = $inv->umur_ekonomis;
            $sisa_unit = $jumlah_barang - $jumlah_unit;
            $barang = $inv->nama;
            $jenis = $inv->jenis;
            $kategori = $inv->kategori;

            $trx_penghapusan = [
                'user_id' => auth()->user()->id,
                'mitra_id' => '0',
                'po_id' => '0',
                'tanggal_transaksi' => $data['tanggal'],
                'rekening_debit' => $data['disimpan_ke'],
                'rekening_kredit' => $data['sumber_dana'],
                'keterangan' => 'Penghapusan ' . $jumlah_unit . ' unit ' . $barang . ' (' . $id_inv . ')' . ' karena ' . $status,
                'jumlah' => $nilai_buku,
                'urutan' => '0',
                'invoice' => 0,
                'kode_spp' => '0',
                'siswa_id' => 0,
                'idtp' => '0',
            ];

            $update_inventaris = [
                'jumlah' => $sisa_unit,
                'tanggal_validasi' => $data['tanggal']
            ];

            $update_status_inventaris = [
                'status' => $status,
                'tanggal_validasi' => $data['tanggal']
            ];

            $insert_inventaris = [
                'nama' => $barang,
                'tanggal_beli' => $tanggal_beli,
                'jumlah' => $jumlah_unit,
                'harga_satuan' => $harga_satuan,
                'umur_ekonomis' => $umur_ekonomis,
                'jenis' => $jenis,
                'kategori' => $kategori,
                'status' => $status,
                'tanggal_validasi' => $data['tanggal'],
            ];

            $trx_penjualan = [
                'user_id' => auth()->user()->id,
                'mitra_id' => '0',
                'po_id' => '0',
                'tgl_transaksi' => $data['tanggal'],
                'rekening_debit' => '1',
                'rekening_kredit' => '55',
                'keterangan_transaksi' => 'Penjualan ' . $jumlah_unit . ' unit ' . $barang . ' (' . $id_inv . ')',
                'jumlah' => $harga_jual,
                'urutan' => '0',
            ];

            if ($status != 'rusak') {
                $transaksi = Transaksi::create($trx_penghapusan);
            }

            if ($jumlah_unit < $jumlah_barang) {
                Inventaris::where('id', $id_inv)->update($update_inventaris);
                if ($status != 'revaluasi') {
                    Inventaris::create($insert_inventaris);
                }
            } else {
                Inventaris::where('id', $id_inv)->update($update_status_inventaris);
            }

            if ($status == 'revaluasi') {
                $harga_jual = Angka::parseInt($request->harga_jual);

                $insert_inventaris_baru = [
                    'nama' => $barang,
                    'tanggal_beli' => $data['tanggal'],
                    'tanggal_validasi' => $data['tanggal'],
                    'jumlah' => $jumlah_unit,
                    'harga_satuan' => $harga_jual / $jumlah_unit,
                    'umur_ekonomis' => $umur_ekonomis,
                    'jenis' => $jenis,
                    'kategori' => $kategori,
                    'status' => 'baik',
                ];

                if ($harga_jual != $nilai_buku) {
                    $jumlah = $harga_jual - $nilai_buku;
                    $trx_revaluasi = [
                        'user_id' => auth()->user()->id,
                        'mitra_id' => '0',
                        'po_id' => '0',
                        'tgl_transaksi' => $data['tanggal'],
                        'rekening_debit' => '1',
                        'rekening_kredit' => '57',
                        'keterangan_transaksi' => 'Revaluasi ' . $jumlah_unit . ' unit ' . $barang . ' (' . $id_inv . ')',
                        'jumlah' => $jumlah,
                        'urutan' => '0',
                    ];

                    Transaksi::create($trx_revaluasi);
                }

                Inventaris::create($insert_inventaris_baru);
            }

            $message = 'Penghapusan ' . $jumlah_unit . ' unit ' . $barang . ' karena ' . $status;
            if ($status == 'dijual') {
                $transaksi = Transaksi::create($trx_penjualan);
                $message = 'Penjualan ' . $jumlah_unit . ' unit ' . $barang;
            }
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Detail jurnal umum.
     */
    public function show(Transaksi $Transaksi)
    {
        //
    }

    public function jurnalUmumDetail(Request $request)
    {
        $query = Transaksi::with(['rekeningDebit', 'rekeningKredit', 'user'])
            ->where('kode_spp', '0')
            ->where('siswa_id', 0)
            ->whereNull('deleted_at');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
            if ($request->filled('bulan')) {
                $query->whereMonth('tanggal_transaksi', $request->bulan);
                if ($request->filled('tanggal')) {
                    $query->whereDay('tanggal_transaksi', $request->tanggal);
                }
            }
        }

        $transaksi = $query->orderByDesc('tanggal_transaksi')->orderByDesc('id')->get();
        $total = $transaksi->sum(fn ($t) => $t->getRawOriginal('jumlah'));

        return view('transaksi.detail.jurnal-umum', compact('transaksi', 'total'));
    }

    public function jurnalUmumCetak(Request $request)
    {
        $query = Transaksi::with(['rekeningDebit', 'rekeningKredit', 'user'])
            ->where('kode_spp', '0')
            ->where('siswa_id', 0)
            ->whereNull('deleted_at');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
            if ($request->filled('bulan')) {
                $query->whereMonth('tanggal_transaksi', $request->bulan);
                if ($request->filled('tanggal')) {
                    $query->whereDay('tanggal_transaksi', $request->tanggal);
                }
            }
        }

        $transaksi = $query->orderByDesc('tanggal_transaksi')->orderByDesc('id')->get();
        $total = $transaksi->sum(fn ($t) => $t->getRawOriginal('jumlah'));

        $transaksi->each(function ($t) {
            $t->jenis_dokumen = $this->detectJenisDokumen($t);
        });

        return view('transaksi.detail.jurnal-umum-cetak', compact('transaksi', 'total'));
    }

    private function detectJenisDokumen(Transaksi $t): string
    {
        $d = $t->rekening_debit;
        $k = $t->rekening_kredit;

        $kas = fn($x) => str_starts_with((string) $x, '1.1.01');
        $bank = fn($x) => str_starts_with((string) $x, '1.1.02');
        $beban = fn($x) => str_starts_with((string) $x, '5.');
        $pendapatan = fn($x) => str_starts_with((string) $x, '4.');

        if ($kas($d) && !$kas($k)) return 'bkk';
        if ($bank($d) && ($kas($k) || $bank($k))) return 'bkk';
        if ($beban($d) && ($kas($k) || $bank($k))) return 'bkk';

        if ($kas($k) && !$kas($d)) return 'bkm';
        if ($bank($k) && ($kas($d) || $bank($d))) return 'bkm';
        if (($kas($d) || $bank($d)) && $pendapatan($k)) return 'bkm';

        return 'bm';
    }

    public function jurnalUmumPrintDokumen(Request $request, string $jenis)
    {
        $allowed = ['bkk', 'bkm', 'bm', 'kuitansi', 'kuitansi_thermal', 'cetak'];
        if (!in_array($jenis, $allowed, true)) {
            abort(404, 'Jenis dokumen tidak dikenal.');
        }

        $ids = array_filter(explode(',', $request->query('ids', '')));
        $query = Transaksi::with(['rekeningDebit', 'rekeningKredit'])
            ->where('kode_spp', '0')
            ->where('siswa_id', 0)
            ->whereNull('deleted_at');

        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }

        $transaksi = $query->orderBy('tanggal_transaksi')->orderBy('id')->get();
        if ($transaksi->isEmpty()) {
            abort(404, 'Tidak ada transaksi untuk dicetak.');
        }

        $profil = \App\Models\Profil::first();
        $data = [
            'profil' => $profil,
            'transaksi' => $transaksi,
            'jenis' => strtoupper(str_replace('_', ' ', $jenis)),
        ];
        $logoPath = \App\Models\Profil::logoPath();
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }

        $view = 'transaksi.detail.dokumen.' . $jenis;
        $isCetak = $jenis === 'cetak';
        $isThermal = $jenis === 'kuitansi_thermal';

        if (!$isCetak) {
            $data['trx'] = $transaksi->first();
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView($view, $data);
        if ($isThermal) {
            $pdf->setPaper([0, 0, 226.77, 254.01]);
        } elseif ($isCetak) {
            $pdf->setPaper('A4', 'landscape');
        } else {
            $pdf->setPaper('A4', 'portrait');
        }

        return $pdf->stream('dokumen-' . $jenis . '.pdf');
    }

    public function jurnalUmumData(Request $request)
    {
        $query = Transaksi::with(['rekeningDebit', 'rekeningKredit', 'user'])
            ->where('kode_spp', '0')
            ->where('siswa_id', 0)
            ->whereNull('deleted_at');

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
            if ($request->filled('bulan')) {
                $query->whereMonth('tanggal_transaksi', $request->bulan);
                if ($request->filled('tanggal')) {
                    $query->whereDay('tanggal_transaksi', $request->tanggal);
                }
            }
        }

        $total = (clone $query)->sum('jumlah');

        return DataTables::eloquent($query->select('transaksi.*'))
            ->addIndexColumn()
            ->addColumn('tgl_fmt', fn ($r) => $r->tanggal_transaksi->format('d-m-Y'))
            ->addColumn('kode_akun', function ($r) {
                $d = $r->rekeningDebit->kode_akun ?? '-';
                $k = $r->rekeningKredit->kode_akun ?? '-';
                return '<div class="small"><div>D: ' . $d . '</div><div>K: ' . $k . '</div></div>';
            })
            ->addColumn('rekening_debit_nama', fn ($r) => $r->rekeningDebit->nama_akun ?? '-')
            ->addColumn('rekening_kredit_nama', fn ($r) => $r->rekeningKredit->nama_akun ?? '-')
            ->addColumn('ket', fn ($r) => $r->keterangan ?: '-')
            ->addColumn('nominal_fmt', fn ($r) => number_format((float) $r->jumlah, 0, ',', '.'))
            ->addColumn('user', fn ($r) => $r->user->nama_lengkap ?? $r->user->name ?? '-')
            ->addColumn('aksi', function ($r) {
                $id = (int) $r->id;
                $base = '/app/Transaksi/jurnal-umum/printDokumen/';
                $html = '<div class="d-inline-flex gap-1">';
                foreach ([
                    'bkk' => ['Bukti Kas Keluar', 'output'],
                    'bkm' => ['Bukti Kas Masuk', 'input'],
                    'bm' => ['Bukti Memorial', 'description'],
                ] as $jenis => [$title, $icon]) {
                    $html .= '<a href="' . $base . $jenis . '?ids=' . $id . '" target="_blank" class="btn btn-secondary btn-compact" title="' . $title . '">'
                        . '<i class="material-symbols-rounded">' . $icon . '</i></a>';
                }
                $html .= '<div class="dropdown">';
                $html .= '<button type="button" class="btn btn-secondary btn-compact dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Kuitansi">'
                    . '<i class="material-symbols-rounded">receipt_long</i></button>';
                $html .= '<ul class="dropdown-menu">';
                foreach ([
                    'kuitansi' => 'Kuitansi',
                    'kuitansi_thermal' => 'Kuitansi Thermal',
                    'cetak' => 'Cetak Bukti',
                ] as $jenis => $title) {
                    $html .= '<li><a href="' . $base . $jenis . '?ids=' . $id . '" target="_blank" class="dropdown-item">' . $title . '</a></li>';
                }
                $html .= '</ul></div>';
                $html .= '<button type="button" class="btn btn-danger btn-compact btnHapusJurnal" data-id="' . $id . '" title="Hapus">'
                    . '<i class="material-symbols-rounded">delete</i></button>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['kode_akun', 'aksi'])
            ->with('total_nominal', 'Rp ' . number_format((float) $total, 0, ',', '.'))
            ->toJson();
    }

    /**
     * Remove detail jurnal umum
     */
    public function destroy(Transaksi $Transaksi)
    {
        //
    }

    public function jurnalUmumDestroy(Transaksi $transaksi)
    {
        $transaksi->update(['deleted_at' => now()]);

        return response()->json([
            'success' => true,
            'msg' => 'Jurnal umum #' . $transaksi->id . ' berhasil dihapus.'
        ]);
    }

    //PEMBAYARAN SPP
    public function pembayaranSPP()
    {
        $title = 'Tagihan Siswa';

        return view('transaksi.pembayaran-spp', compact('title'));
    }

    /**
     * Store PEMBAYARAN SPP
     */
    public function pembayaranSPPStore(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'siswa_id' => 'required',
            'sumber_dana' => 'required',
            'jenis_biaya' => 'required',
            'keterangan' => 'required',
        ]);

        $jp = JenisPembayaran::byKodeAkun($request->jenis_biaya);
        if (!$jp) {
            return response()->json([
                'success' => false,
                'msg' => 'Jenis pembayaran tidak ditemukan di master.'
            ], 422);
        }
        $isSpp = $jp->isSpp();

        $kodeSpp  = $request->input('kode_spp', []);
        $nominals = $request->input('nominal_spp', []);

        $transaksiList = [];
        $detailSpp = [];
        $idtp = str_pad((int) Transaksi::max('idtp') + 1, 4, '0', STR_PAD_LEFT);

        if ($isSpp) {
            $request->validate([
                'kode_spp' => 'required|array|min:1',
                'nominal_spp' => 'required|array',
            ]);

            if (count($kodeSpp) !== count($nominals)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Data SPP tidak sinkron'
                ], 422);
            }
            foreach ($kodeSpp as $i => $kode) {

                $nilai = Angka::parseInt($nominals[$i]);
                $spp   = Spp::where('kode', $kode)->firstOrFail();

                $isTunggakan = Carbon::parse($spp->tanggal)
                    ->lt(Carbon::parse($request->tanggal)->startOfMonth());

                if ($isTunggakan) {
                    Transaksi::where('kode_spp', $kode)
                        ->whereNull('deleted_at')
                        ->update(['deleted_at' => now()]);
                }

                $rekeningKredit = $isTunggakan ? JenisPembayaran::KODE_PIUTANG_DEFAULT : $jp->kode_akun;

                $transaksi = Transaksi::create([
                    'tanggal_transaksi' => $request->tanggal,
                    'idtp' => $idtp,
                    'invoice' => 0,
                    'rekening_debit' => $request->sumber_dana,
                    'rekening_kredit' => $rekeningKredit,
                    'kode_spp' => $spp->kode,
                    'siswa_id' => $request->siswa_id,
                    'jumlah' => $nilai,
                    'keterangan' => $request->keterangan . '(' .
                        Tanggal::namaBulan($spp->tanggal) . ' ' .
                        Tanggal::tahun($spp->tanggal) . ')',
                    'user_id' => auth()->user()->id,
                    'urutan' => '0',
                ]);

                $detailSpp[] = ['bulan' => Tanggal::namaBulan($spp->tanggal) . ' ' . Tanggal::tahun($spp->tanggal)];

                $spp->markLunas($request->tanggal);
                $transaksiList[] = $transaksi;
            }
        } else {
            $transaksi = Transaksi::create([
                'tanggal_transaksi' => $request->tanggal,
                'idtp' => $idtp,
                'invoice' => 0,
                'rekening_debit' => $request->sumber_dana,
                'rekening_kredit' => $jp->kode_akun,
                'kode_spp' => '0',
                'siswa_id' => $request->siswa_id,
                'jumlah' => Angka::parseInt($request->nominal),
                'keterangan' => $request->keterangan,
                'user_id' => auth()->user()->id,
                'urutan' => '0',
            ]);

            $transaksiList[] = $transaksi;
        }

        $bulan = (int) Carbon::parse($request->tanggal)->format('n');
        $tahun = (int) Carbon::parse($request->tanggal)->format('Y');
        $totalJumlah = collect($transaksiList)->sum('jumlah');
        $kreditAkunKode = $transaksiList[0]->rekening_kredit;

        $debitAkun = Saldo::firstOrCreate(
            ['kode_akun' => $request->sumber_dana, 'bulan' => $bulan, 'tahun' => $tahun],
            ['debit' => 0, 'kredit' => 0]
        );
        $debitAkun->increment('debit', $totalJumlah);

        $kreditAkun = Saldo::firstOrCreate(
            ['kode_akun' => $kreditAkunKode, 'bulan' => $bulan, 'tahun' => $tahun],
            ['debit' => 0, 'kredit' => 0]
        );
        $kreditAkun->increment('kredit', $totalJumlah);

        return response()->json([
            'success' => true,
            'msg' => 'Pembayaran berhasil disimpan',
            'keterangan' => $request->keterangan,
            'id_transaksi' => collect($transaksiList)->pluck('id')->toArray(),
            'idtp' => $idtp,
            'detail_spp' => $detailSpp,
        ]);
    }

    /**
     * Detail PEMBAYARAN SPP
     */
    public function pembayaranSPPDetail($id)
    {
        $siswa = Siswa::with([
            'getKelas',
            'getTransaksi' => function ($q) {
                $q->whereNull('deleted_at')
                    ->orderByDesc('id')
                    ->with(['spp', 'rekeningDebit', 'rekeningKredit']);
            }
        ])->findOrFail($id);

        return view('transaksi.map_arsip.detail', compact('siswa'));
    }
    public function pembayaranSPPPrintAll($id)
    {
        $siswa = Siswa::with([
            'getKelas',
            'getTransaksi' => function ($q) {
                $q->whereNull('deleted_at')
                    ->orderByDesc('id')
                    ->with('spp');
            }
        ])->findOrFail($id);

        return view('transaksi.map_arsip.detail_cetak', compact('siswa'));
    }

    /**
     * Print PEMBAYARAN SPP
     */
    public function pembayaranSPPPrint(Request $request)
    {
        $idtp = $request->query('idtp');
        $query = Transaksi::with('siswa')->whereNull('deleted_at');

        if ($idtp) {
            $query->where('idtp', $idtp);
        } else {
            $ids = explode(',', $request->query('ids'));
            $query->whereIn('id', $ids);
        }

        $transaksis = $query->get();

        if ($transaksis->isEmpty()) {
            abort(404);
        }

        $header = $transaksis->first();
        $lembaga = Profil::first()->nama;
        $allSpps = collect();

        foreach ($transaksis as $transaksi) {
            $sppKodes = array_values(array_filter((array) $transaksi->kode_spp, fn ($v) => $v !== null && $v !== ''));

            $spps = $sppKodes ? Spp::whereIn('kode', $sppKodes)->get() : collect();
            $allSpps = $allSpps->merge($spps);
        }

        $data = [
            'title'         => 'Kwitansi Pembayaran SPP',
            'header'        => $header,
            'spps'          => $allSpps,
            'transaksis'    => $transaksis,
            'nama_lembaga'  => $lembaga,
        ];
        $logoPath = \App\Models\Profil::logoPath();
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }
        $pdf = Pdf::loadView('transaksi.map_arsip.view.kwitansi_spp', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('kwitansi_spp.pdf');
    }

    public function printAllSelected(Request $request)
    {
        $ids = explode(',', $request->query('ids'));

        $transaksis = Transaksi::with('siswa')
            ->whereIn('id', $ids)
            ->get();

        if ($transaksis->isEmpty()) {
            abort(404, 'Transaksi tidak ditemukan.');
        }

        $header = $transaksis->first();

        $lembaga = Profil::first()->nama;
        $data = [
            'title'        => 'Riwayat Pembayaran',
            'header'       => $header,
            'transaksis'   => $transaksis,
            'nama_lembaga' => $lembaga,
        ];
        $logoPath = \App\Models\Profil::logoPath();
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }
        $pdf = Pdf::loadView('transaksi.map_arsip.view.cetak', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('cetak.pdf');
    }

    public function CetakPadaKartu(Request $request)
    {
        $ids = explode(',', $request->query('ids'));
        $transaksis = Transaksi::with('siswa', 'spp')
            ->whereIn('id', $ids)
            ->get();

        if ($transaksis->isEmpty()) {
            abort(404, 'Transaksi tidak ditemukan.');
        }

        return view('transaksi.map_arsip.view.cetakPadaKartu', [
            'transaksis' => $transaksis
        ]);
    }

    public function cetakKartuSpp($id)
    {
        $siswa = Siswa::with('tahunAkademik')->findOrFail($id);
        $profil = Profil::first();
        $tahun_pel = $siswa->tahunAkademik->nama_tahun
            ?? \App\Models\Tahun_Akademik::where('status', 'aktif')->value('nama_tahun')
            ?? date('Y');

        $data = [
            'siswa'        => $siswa,
            'profil'       => $profil,
            'tahun_pel'    => $tahun_pel,
            'spp_perbulan' => $siswa->spp_nominal ?? 0,
        ];

        $logoPath = \App\Models\Profil::logoPath();
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }

        $pdf = Pdf::loadView('transaksi.map_arsip.view.cetak_kartu_spp', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('kartu-spp-'.$siswa->nama.'.pdf');
    }

    public function cetakKartuUjian($id, $jenis)
    {
        $allowed = ['uts1', 'pas1', 'uts2', 'pas2'];
        if (!in_array($jenis, $allowed, true)) {
            abort(404, 'Jenis kartu tidak dikenal.');
        }

        [$kat, $periode] = $this->splitJenisKartu($jenis);

        $siswa = Siswa::findOrFail($id);
        $profil = Profil::first();

        $subjudulMap = [
            'uts' => 'UJIAN TENGAH SEMESTER',
            'pas' => 'PENILAIAN AKHIR SEMESTER',
        ];
        $periodeRoman = ($periode == '1') ? 'I' : 'II';

        $no_peserta = trim(($siswa->nipd ?? '').' - '.$siswa->nisn, ' -');
        $lokasi = $profil->alamat ? trim(explode(',', $profil->alamat)[0]) : null;

        $data = [
            'siswa'         => $siswa,
            'profil'        => $profil,
            'periode'       => $periode,
            'no_peserta'    => $no_peserta,
            'jenis_ujian'   => $subjudulMap[$kat].' '.$periodeRoman,
            'lokasi'        => $lokasi,
        ];

        $logoPath = \App\Models\Profil::logoPath();
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }

        $pdf = Pdf::loadView('transaksi.map_arsip.view.cetak_kartu_'.$kat, $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('kartu-'.$jenis.'-'.$siswa->nama.'.pdf');
    }

    private function splitJenisKartu(string $jenis): array
    {
        return [
            substr($jenis, 0, 3),
            substr($jenis, 3, 1),
        ];
    }

    /**
     * Remove PEMBAYARAN SPP
     */
    public function pembayaranSPPDestroy(Transaksi $Transaksi)
    {
        $kodeSpp = $Transaksi->kode_spp;
        if ($kodeSpp) {
            $spp = Spp::where('kode', $kodeSpp)->first();
            $spp?->batalLunas();

            // kembalikan tagihan tunggakan yang sebelumnya di-soft-delete saat pembayaran
            Transaksi::where('kode_spp', $kodeSpp)
                ->where('rekening_debit', JenisPembayaran::KODE_PIUTANG_DEFAULT)
                ->whereNotNull('deleted_at')
                ->update(['deleted_at' => null]);
        }

        $Transaksi->update(['deleted_at' => now()]);

        return response()->json([
            'success' => true,
            'msg' => 'Transaksi pembayaran SPP berhasil dibatalkan.'
        ]);
    }
}
