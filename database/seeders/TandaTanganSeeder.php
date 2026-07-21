<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TandaTanganSeeder extends Seeder
{
    public function run(): void
    {
        $html = '<table class=\\\"p0\\\" border=\\\"0\\\" width=\\\"100%\\\" cellspacing=\\\"0\\\" cellpadding=\\\"0\\\" style=\\\"font-size: 11px;\\\">\n<tbody>\n<tr>\n<td style=\\\"width: 33.3333%;\\\">&nbsp;</td>\n<td style=\\\"width: 33.3333%;\\\">&nbsp;</td>\n<td style=\\\"width: 33.3333%; text-align: center;\\\">{tanggal}</td>\n</tr>\n</tbody>\n<tbody>\n<tr>\n<td style=\\\"text-align: center;\\\">Diperiksa Oleh</td>\n<td style=\\\"text-align: center;\\\">Diketahui</td>\n<td style=\\\"text-align: center;\\\">Dilaporkan</td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\">\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n</td>\n<td style=\\\"text-align: center;\\\">&nbsp;</td>\n<td style=\\\"text-align: center;\\\">&nbsp;</td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\">..........rrr.....rrr.............</td>\n<td style=\\\"text-align: center;\\\">...............................................</td>\n<td style=\\\"text-align: center;\\\"><strong>......................................</strong></td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\"><strong>Badan Pengawas</strong></td>\n<td style=\\\"text-align: center;\\\"><strong>Manager DBM</strong></td>\n<td style=\\\"text-align: center;\\\"><strong>Bendahara</strong></td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\">Disetujui Oleh</td>\n<td style=\\\"text-align: center;\\\" colspan=\\\"2\\\">&nbsp;</td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\">\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n<p>&nbsp;</p>\n</td>\n<td style=\\\"text-align: center;\\\">&nbsp;</td>\n<td style=\\\"text-align: center;\\\">&nbsp;</td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\"><strong>......................................</strong></td>\n<td style=\\\"text-align: center;\\\" colspan=\\\"2\\\">&nbsp;</td>\n</tr>\n<tr>\n<td style=\\\"text-align: center;\\\"><strong>Direktur</strong></td>\n<td style=\\\"text-align: center;\\\" colspan=\\\"2\\\">&nbsp;</td>\n</tr>\n</tbody>\n</table>';

        DB::table('tanda_tangan')->insertOrIgnore([
            [
                'id' => 1,
                'tanda_tangan' => $html,
                'created_at' => '2026-07-16 23:56:20',
                'updated_at' => '2026-07-16 23:56:20',
            ],
        ]);
    }
}