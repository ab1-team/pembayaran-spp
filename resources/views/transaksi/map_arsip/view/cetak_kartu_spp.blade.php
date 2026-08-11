@php
    use App\Utils\Angka;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu SPP - {{ $siswa->nama }}</title>
    <style>
        @page { margin: 20mm 15mm; }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        .header {
            display: table;
            width: 100%;
            padding-bottom: 6px;
        }
        .header .logo,
        .header .info {
            display: table-cell;
            vertical-align: middle;
        }
        .header .logo { width: 65px; }
        .header .logo img { width: 60px; height: auto; }
        .header .info { text-align: center; }
        .header .info .l1 { font-weight: bold; font-size: 10px; }
        .header .info .l2 { font-weight: bold; font-size: 12px; margin: 2px 0; }
        .header .info .l3 { font-size: 9px; }
        .header .info .l4 { font-size: 9px; }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 6px 0;
            margin-top: 6px;
        }

        .identitas {
            margin-top: 10px;
        }
        .identitas table { width: 100%; border: none; }
        .identitas td { padding: 2px 0; vertical-align: top; font-size: 9px; }
        .identitas td:first-child { width: 20%; }
        .identitas td:last-child { font-size: 10px; font-weight: bold; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 9px;
        }
        table.data th { text-align: center; font-weight: bold; }
        table.data .no { width: 7%; text-align: center; }
        table.data .tgl { width: 30%; text-align: center; }
        table.data .jumlah { width: 20%; }
        table.data .sign { width: 15%; }
        table.data td.empty-row { height: 240px; vertical-align: top; }

        .keterangan {
            margin-top: 12px;
            font-size: 8px;
        }
        .keterangan ol { margin: 0; padding-left: 18px; }

        .ttd {
            margin-top: 18px;
            width: 100%;
            border: none;
            font-size: 9px;
        }
        .ttd td { border: none; vertical-align: top; }
        .ttd td:first-child { width: 40%; }
        .ttd .kanan { width: 60%; text-align: center; }
        .ttd .kanan .jabatan { font-weight: bold; }
        .ttd .kanan .space { height: 50px; }
        .ttd .kanan .nama { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            @if (!empty($logo))
                <img src="data:image/{{ $logo_type }};base64,{{ $logo }}" alt="logo">
            @endif
        </div>
        <div class="info">
            <div class="l1">{{ strtoupper($profil->nama ?? '') }}</div>
            <div class="l3">{{ $profil->alamat ?? '' }}</div>
            <div class="l4">Telp. {{ $profil->telpon ?? '' }}</div>
        </div>
    </div>

    <div class="title">KARTU SPP</div>

    <div class="identitas">
        <table>
            <tr><td>Nama Siswa</td><td>: <strong>{{ strtoupper($siswa->nama) }}</strong></td></tr>
            <tr><td>Kelas</td><td>: {{ $anggotaAktif->kode_kelas ?? $siswa->kode_kelas }}</td></tr>
            <tr><td>Ta.Pel</td><td>: {{ $tahun_pel }}</td></tr>
            <tr><td>Nominal</td><td>: {{ Angka::format($spp_perbulan ?? 0, 0) }}</td></tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th class="no">NO</th>
                <th class="tgl">TANGGAL</th>
                <th>KETERANGAN</th>
                <th class="jumlah">JUMLAH</th>
                <th class="sign">SIGN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no empty-row">&nbsp;</td>
                <td class="tgl empty-row">&nbsp;</td>
                <td class="empty-row">&nbsp;</td>
                <td class="jumlah empty-row">&nbsp;</td>
                <td class="sign empty-row">&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <div class="keterangan">
        <strong>Keterangan:</strong>
        <ol>
            <li>Pembayaran paling lambat tanggal 10 tiap bulan, dimulai bulan Juli.</li>
            <li>Bawalah kartu dan Mintalah kwitansi setiap kali pembayaran.</li>
            <li>Cek status pembayaran melalui aplikasi SABIT di www.sabit.sditat.sch.id</li>
        </ol>
    </div>

    <table class="ttd">
        <tr>
            <td></td>
            <td class="kanan">
                <div class="jabatan">Bendahara</div>
                <div class="space">&nbsp;</div>
                <div class="nama">MASLAKHATUL UMAH</div>
            </td>
        </tr>
    </table>

</body>
</html>
