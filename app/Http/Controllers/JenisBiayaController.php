<?php

namespace App\Http\Controllers;

use App\Models\Jenis_Biaya;
use App\Models\JenisPembayaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisBiayaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Jenis_Biaya::with('get_jenis_pembayaran');
            return DataTables::eloquent($data)
                ->addIndexColumn()
                ->addColumn('nama_jenis', function ($row) {
                    return $row->get_jenis_pembayaran->nama ?? '-';
                })
                ->addColumn('kode_akun', function ($row) {
                    return $row->get_jenis_pembayaran->kode_akun ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-inline-flex gap-1">
                            <button class="btn btn-warning btnEdit" data-id="'.$row->id.'">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger btnDelete" data-id="'.$row->id.'">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->toJson();
        }
        return view('jenis_biaya.index', ['title' => 'Jenis Keuangan']);
    }

    public function create()
    {
        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();
        $title = 'Tambah Nominal Keuangan';

        return view('jenis_biaya.create', compact('title', 'jenisPembayaran'));
    }

    public function createForm()
    {
        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();
        return response()->json([
            'html' => view('jenis_biaya._form', [
                'mode'           => 'create',
                'jenisPembayaran' => $jenisPembayaran,
                'jenis_biaya'    => new Jenis_Biaya(),
            ])->render(),
        ]);
    }

    public function editForm(Jenis_Biaya $jenis_biaya)
    {
        $jenis_biaya->load('get_jenis_pembayaran');
        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();
        return response()->json([
            'html' => view('jenis_biaya._form', [
                'mode'           => 'edit',
                'jenisPembayaran' => $jenisPembayaran,
                'jenis_biaya'    => $jenis_biaya,
            ])->render(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'total_beban' => 'required',
            'angkatan'    => 'required',
            'id_jp'       => 'required|exists:jenis_pembayaran,id',
        ]);

        Jenis_Biaya::create([
            'id_jp'       => $data['id_jp'],
            'angkatan'    => $data['angkatan'],
            'total_beban' => $this->normalizeNominal($data['total_beban']),
        ]);

        return response()->json([
            'success' => true,
            'msg'     => 'Jenis Biaya berhasil ditambahkan',
        ]);
    }

    public function edit(Jenis_Biaya $jenis_biaya)
    {
        $jenis_biaya->load('get_jenis_pembayaran');
        $jenisPembayaran = JenisPembayaran::orderBy('nama')->get();
        $title = 'Edit Nominal Keuangan';

        return view('jenis_biaya.edit', compact('title', 'jenisPembayaran', 'jenis_biaya'));
    }

    public function update(Request $request, Jenis_Biaya $jenis_biaya)
    {
        $data = $request->validate([
            'total_beban' => 'required',
            'angkatan'    => 'required',
            'id_jp'       => 'required|exists:jenis_pembayaran,id',
        ]);

        $jenis_biaya->update([
            'id_jp'       => $data['id_jp'],
            'angkatan'    => $data['angkatan'],
            'total_beban' => $this->normalizeNominal($data['total_beban']),
        ]);

        return response()->json([
            'success' => true,
            'msg'     => 'Jenis Biaya berhasil diupdate',
        ]);
    }

    public function destroy(Jenis_Biaya $jenis_biaya)
    {
        $jenis_biaya->delete();
        return response()->json([
            'success' => true,
            'msg'     => 'Data Biaya berhasil dihapus',
        ]);
    }

    private function normalizeNominal($value): int
    {
        return (int) str_replace(['.', ','], '', (string) $value);
    }
}
