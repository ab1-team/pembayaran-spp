<?php
require __DIR__ . '/bootstrap/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Carbon\Carbon;

$html = view('laporan-keuangan.views.pembayaran_spp', [
    'title' => 'Laporan Pembayaran SPP',
    'kelas' => (object) ['kode_kelas' => 'I.A'],
    'periode' => [
        'awal'  => Carbon::parse('2026-07-01')->locale('id'),
        'akhir' => Carbon::parse('2026-07-31')->locale('id'),
    ],
    'bulanList' => [Carbon::parse('2026-07-01'), Carbon::parse('2026-08-01')],
    'anggotaKelas' => collect([
        (object) [
            'getSiswa' => (object) ['nisn' => '123', 'nama' => 'Budi'],
            'per_bulan' => 200000,
            'bulan_list' => collect([
                (object) ['bulan' => Carbon::parse('2026-07-01'), 'tagihan' => 200000, 'bayar' => 200000, 'status' => 'L'],
                (object) ['bulan' => Carbon::parse('2026-08-01'), 'tagihan' => 200000, 'bayar' => 0, 'status' => null],
            ]),
            'target_sd_saat_ini' => 400000,
            'sd_periode_ini' => 200000,
            'sisa' => 200000,
        ],
    ]),
])->render();

echo $html;
