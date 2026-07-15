<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Anggota_Kelas;
use App\Models\Ruangan;
use App\Models\Jenis_Biaya;
use App\Models\Tahun_akademik;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Http\Requests\SiswaRequest;
use App\Services\SiswaService;


class SiswaController extends Controller
{
    public function __construct(protected SiswaService $service) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Siswa::select('id', 'nisn', 'nama', 'angkatan', 'kode_kelas', 'status_siswa');

            // Filter tahun akademik
            if ($request->tahun_akademik) {
                $tahun = explode('/', $request->tahun_akademik);
                $query->whereIn('angkatan', $tahun);
            }

            // Filter kelas
            if ($request->kelas) {
                $query->where('kode_kelas', $request->kelas);
            }

            return DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<div class="form-check">
                                <input class="form-check-input checkItem" type="checkbox" value="' . $row->id . '">
                            </div>';
                })
                ->addColumn('action', function ($row) use ($request) {
                    return '
                                <button class="btn btn-secondary btnMutasi"
                                    data-id="' . $row->id . '"
                                    title="Mutasi Siswa">
                                    <i class="fa-solid fa-right-left"></i>
                                </button>
                            ';
                })
                ->rawColumns(['checkbox', 'action'])
                ->toJson();
        }

        return view('siswa.index', ['title' => 'Data Siswa']);
    }

    public function listTahun(Request $request)
    {
        $search = $request->get('q');

        $query = Tahun_akademik::select('id', 'nama_tahun')->where('status', 'aktif')
            ->orderByDesc('nama_tahun');
        if ($search) {
            $query->where('nama_tahun', 'like', "%{$search}%");
        }

        return response()->json(
            $query->get()->map(fn($item) => [
                'id'            => $item->id,
                'nama_tahun'    => $item->nama_tahun
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
                'id'            => $item->id,
                'nama_kelas'    => $item->nama_kelas,
                'kode_kelas'    => $item->kode_kelas,
                'tingkat'       => $item->tingkat,
            ])
        );
    }

    public function printSiswa(Request $request)
    {
        $ids = explode(',', $request->ids);
        $siswa = Siswa::whereIn('id', $ids)->get();

        $title = 'Daftar Siswa';
        $data = [
            'title' => $title,
            'siswa' => $siswa
        ];
        $logoPath = public_path('assets/img/apple-icon.png');
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }
        $pdf = Pdf::loadView('siswa.view.print', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('daftar_siswa.pdf');
    }

    public function mutasi(Request $request)
    {
        $request->validate([
            'kelas' => 'required|string',
            'ids'   => 'required|array',
        ]);

        [$kodeKelasBaru, $tingkatBaru] = $this->service->splitKelas($request->kelas);

        $year = Carbon::now()->year;
        $tahunAkademik = $year . '/' . ($year + 1);
        $tglMasuk = Carbon::today();
        $tglKeluar = Carbon::today()->addYear();

        foreach ($request->ids as $idSiswa) {
            $siswa = Siswa::find($idSiswa);
            if (!$siswa) continue;

            $siswa->update([
                'tingkat'    => $tingkatBaru,
                'kode_kelas' => $kodeKelasBaru,
            ]);

            $anggota = Anggota_Kelas::where('id_siswa', $idSiswa)
                ->orderByDesc('id')
                ->first();

            if ($anggota && $anggota->tingkat === $tingkatBaru) {
                $anggota->update(['kode_kelas' => $kodeKelasBaru]);
                continue;
            }

            if ($anggota) {
                $anggota->update(['status' => 'nonaktif']);
            }

            $anggotaBaru = Anggota_Kelas::create([
                'id_siswa'       => $idSiswa,
                'tahun_akademik' => $tahunAkademik,
                'tingkat'        => $tingkatBaru,
                'kode_kelas'     => $kodeKelasBaru,
                'tgl_masuk'      => $tglMasuk->format('Y-m-d'),
                'tgl_keluar'     => $tglKeluar->format('Y-m-d'),
                'status'         => 'aktif',
            ]);

            $this->service->generateSppBulanan(
                $anggotaBaru,
                $this->service->normalizeNominal($siswa->spp_nominal),
                ['tanggal_masuk' => $tglMasuk->format('Y-m-d')]
            );
        }

        return response()->json([
            'success' => true,
            'msg'     => 'Mutasi berhasil diproses!',
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title          = "Tambah Siswa";
        $kelas          = Kelas::get();
        $ruang          = Ruangan::get();
        $jurusan        = Jurusan::get();
        $tahunAkademmik = Tahun_akademik::get();
        $jenisBiaya     = Jenis_Biaya::whereHas('get_jenis_pembayaran', fn($q) => $q->where('kode_akun', '4.1.01.01'))
            ->where('angkatan', date('Y'))
            ->first();

        return view('siswa.create', compact('title', 'kelas', 'jurusan', 'jenisBiaya', 'ruang', 'tahunAkademmik'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiswaRequest $request)
    {
        $data = $request->validated();
        $data['foto'] = $this->handleFoto($request);

        $siswa = $this->service->createWithKelasDanSpp($data);

        return response()->json([
            'success' => true,
            'msg'     => 'Siswa berhasil disimpan',
            'data'    => $siswa,
        ]);
    }

    private function handleFoto(Request $request, ?string $existing = null): string
    {
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('siswa', $fileName, 'public');
            return $fileName;
        }
        return $existing ?? 'default.png';
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $title = "Detail Siswa";
        $siswa = Siswa::where('id', $siswa->id)->first();
        $riwayat = Transaksi::with('spp')->where('siswa_id', $siswa->id)->get();

        return view('siswa.detail', compact('title', 'siswa', 'riwayat'));
    }

    public function riwayatPembayaran($id)
    {
        $siswa = Siswa::where('id', $id)->first();
        $riwayat = Transaksi::with('spp')
            ->where('siswa_id', $siswa->id)
            ->get();

        $data = [
            'title'   => 'Riwayat Pembayaran Siswa',
            'riwayat' => $riwayat,
            'siswa'   => $siswa,
        ];

        $logoPath = public_path('assets/img/apple-icon.png');
        if (file_exists($logoPath)) {
            $data['logo'] = base64_encode(file_get_contents($logoPath));
            $data['logo_type'] = pathinfo($logoPath, PATHINFO_EXTENSION);
        }

        $pdf = Pdf::loadView('siswa.view.riwayatPembayaran', $data);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream('Riwayat_pembayaran.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function  edit(Siswa $siswa)
    {
        $title          = "Edit Siswa";
        $kelas          = Kelas::get();
        $ruang          = Ruangan::get();
        $jurusan        = Jurusan::get();
        $tahunAkademmik = Tahun_akademik::get();
        $jenisBiaya     = Jenis_Biaya::whereHas('get_jenis_pembayaran', fn($q) => $q->where('kode_akun', '4.1.01.01'))
            ->where('angkatan', date('Y'))
            ->first();

        return view('siswa.edit', compact('title', 'kelas', 'jurusan', 'jenisBiaya', 'siswa', 'ruang', 'tahunAkademmik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiswaRequest $request, Siswa $siswa)
    {
        $data = $request->validated();
        $data['foto'] = $this->handleFoto($request, $siswa->foto);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        [$kodeKls, $tingkat] = $this->service->splitKelas($data['kelas']);
        $data['kode_kelas'] = $kodeKls;
        $data['tingkat'] = $tingkat;
        $data['ruang'] = $data['ruangan'];
        $data['id_user'] = auth()->id();
        $data['alat_transportasi'] = $data['transportasi'];
        $data['no_telepon_ayah'] = $data['no_telp_ayah'];
        $data['no_telepon_ibu'] = $data['no_telp_ibu'];
        $data['no_telepon_wali'] = $data['no_telp_wali'];
        $data['spp_nominal'] = (string) $this->service->normalizeNominal($data['spp_nominal']);

        unset($data['kelas'], $data['ruangan'], $data['transportasi'],
              $data['no_telp_ayah'], $data['no_telp_ibu'], $data['no_telp_wali']);

        $siswa->update($data);

        return response()->json([
            'success' => true,
            'msg'     => 'Siswa berhasil diupdate',
            'data'    => $siswa,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->update([
            'status_siswa' => 'blokir'
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Siswa berhasil diblokir',
        ]);
    }
}
