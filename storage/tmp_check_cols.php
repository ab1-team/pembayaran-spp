<?php
$cols = \Illuminate\Support\Facades\Schema::getColumnListing('siswa');
foreach (['kode_jurusan','spp_nominal','tingkat','telepon','angkatan'] as $c) {
    echo $c . ': ' . (in_array($c, $cols) ? 'ADA' : 'TIDAK ADA') . PHP_EOL;
}