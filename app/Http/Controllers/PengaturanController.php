<?php

namespace App\Http\Controllers;

use App\Models\AkunLevel1;
use App\Models\AkunLevel2;
use App\Models\AkunLevel3;
use App\Models\Rekening;
use App\Models\Profil;
use App\Models\Kelas;
use App\Models\Tanda_tangan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function sop()
    {
        $profil = Profil::first();

        $title = "Personalisasi SOP";
        return view('pengaturan.index', compact('title', 'profil',));
    }

    public function coa()
    {
        $title = "Chart Of Account (CoA)";
        $akun1 = AkunLevel1::with([
            'akun2',
            'akun2.akun3',
            'akun2.akun3.rek'
        ])->get();

        return view('pengaturan.coa')->with(compact('title', 'akun1'));
    }

    public function ttdPelaporan()
    {
        $title = "Pengaturan Tanda Tangan Pelaporan";

        if (!Tanda_tangan::first()) {
            Tanda_tangan::create([
                'tanda_tangan' => '<table class="p0" border="0" width="100%" cellspacing="0" cellpadding="0" style="font-size: 11px;">
<tbody>
<tr>
<td style="width: 33.3333%;">&nbsp;</td>
<td style="width: 33.3333%;">&nbsp;</td>
<td style="width: 33.3333%; text-align: center;">{tanggal}</td>
</tr>
</tbody>
<tbody>
<tr>
<td style="text-align: center;">Diperiksa Oleh</td>
<td style="text-align: center;">Diketahui</td>
<td style="text-align: center;">Dilaporkan</td>
</tr>
<tr>
<td style="text-align: center;">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</td>
<td style="text-align: center;">&nbsp;</td>
<td style="text-align: center;">&nbsp;</td>
</tr>
<tr>
<td style="text-align: center;">..........rrr.....rrr.............</td>
<td style="text-align: center;">...............................................</td>
<td style="text-align: center;"><strong>......................................</strong></td>
</tr>
<tr>
<td style="text-align: center;"><strong>Badan Pengawas</strong></td>
<td style="text-align: center;"><strong>Manager DBM</strong></td>
<td style="text-align: center;"><strong>Bendahara</strong></td>
</tr>
<tr>
<td style="text-align: center;">Disetujui Oleh</td>
<td style="text-align: center;" colspan="2">&nbsp;</td>
</tr>
<tr>
<td style="text-align: center;">
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</td>
<td style="text-align: center;">&nbsp;</td>
<td style="text-align: center;">&nbsp;</td>
</tr>
<tr>
<td style="text-align: center;"><strong>......................................</strong></td>
<td style="text-align: center;" colspan="2">&nbsp;</td>
</tr>
<tr>
<td style="text-align: center;"><strong>Direktur</strong></td>
<td style="text-align: center;" colspan="2">&nbsp;</td>
</tr>
</tbody>
</table>',
            ]);
        }

        $ttd = Tanda_tangan::first();

        $tanggal = false;
        if ($ttd) {
            $str = strpos($ttd->tanda_tangan, '{tanggal}');

            if ($str !== false) {
                $tanggal = true;
            }
        }

        return view('pengaturan.tanda_tangan')->with(compact('title', 'ttd', 'tanggal'));
    }

    public function ttdPelaporanStore(Request $request)
    {
        $request->validate([
            'tanda_tangan' => 'required',
        ]);

        $ttd = Tanda_tangan::first();

        $data = [
            'tanda_tangan' => $request->tanda_tangan,
        ];

        if ($ttd) {
            $ttd->update($data);
        } else {
            Tanda_tangan::create($data);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Tanda tangan pelaporan berhasil disimpan',
        ]);
    }


    public function lembaga(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telpon' => 'required',
            'penanggung_jawab' => 'required',
        ]);
        Profil::findOrFail($id)->update($request->all());

        return response()->json([
            'success' => true,
            'msg' => "Update Lembaga berhasil diproses!"

        ]);
    }

    public function logo(Request $request, $id)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'logo.required' => 'Pilih file logo terlebih dahulu.',
            'logo.image'    => 'File harus berupa gambar.',
            'logo.mimes'    => 'Format logo harus JPG, JPEG, atau PNG.',
            'logo.max'      => 'Ukuran logo maksimal 2MB.',
        ]);

        $profil = Profil::findOrFail($id);

        if ($profil->logo && Storage::disk('public')->exists('logo/' . $profil->logo)) {
            Storage::disk('public')->delete('logo/' . $profil->logo);
        }

        $file = $request->file('logo');
        $name = $file->hashName();
        $file->storeAs('logo', $name, 'public');

        $profil->update([
            'logo' => $name
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Logo berhasil diperbarui',
            'logo' => asset('storage/logo/' . $name),
        ]);
    }

    public function jatuhTempo(Request $request, $id)
    {
        $request->validate([
            'jatuh_tempo' => 'required|integer|min:0',
        ]);
        Profil::findOrFail($id)->update($request->all());

        return response()->json([
            'success' => true,
            'msg' => "Update Jatuh Tempo berhasil diproses!"
        ]);
    }
}
