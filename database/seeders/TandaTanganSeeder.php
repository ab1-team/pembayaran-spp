<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TandaTanganSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('tanda_tangan')->exists()) {
            return;
        }

        DB::table('tanda_tangan')->insert([
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
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
