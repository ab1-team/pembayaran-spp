@php
    use App\Utils\Angka;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu SPP - {{ $siswa->nama }}</title>
    <style>
        /* Kertas tetap F4 penuh (215 x 330 mm). Konten dibungkus dalam
           .cetak-area selebar setengah F4 (107.5mm dari tepi kiri),
           dibatasi garis border-right sebagai panduan potong. Sisi kanan
           kertas otomatis kosong/tidak tercetak apa-apa. */
        @page { margin: 10mm 0 10mm 7.5mm; }

        body {
            font-family: Arial, sans-serif;
            font-size: 6px;
            margin: 0;
        }

        .cetak-area {
            width: 95mm;
            padding-right: 5mm;
            border-right: 1px dashed #000;
            box-sizing: content-box;
        }

        .header {
            display: table;
            width: 100%;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }
        .header .logo,
        .header .info {
            display: table-cell;
            vertical-align: middle;
        }
        .header .logo { width: 40px; }
        .header .logo img { width: 35px; height: auto; }
        .header .info { text-align: center; }
        .header .info .l1 { font-weight: bold; font-size: 7px; }
        .header .info .l2 { font-weight: bold; font-size: 8px; margin: 1px 0; }
        .header .info .l3 { font-size: 6px; }
        .header .info .l4 { font-size: 6px; }

        .title {
            text-align: center;
            font-weight: bold;
            font-size: 8px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 3px 0;
            margin-top: 3px;
            letter-spacing: 1px;
        }

        .identitas {
            margin-top: 5px;
            font-size: 6px;
        }
        .identitas table { width: 100%; border: none; }
        .identitas td { padding: 1px 0; vertical-align: top; }
        .identitas td:first-child { width: 55px; }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }
        table.data th,
        table.data td {
            border: 1px solid #000;
            padding: 3px;
        }
        table.data th { text-align: center; font-weight: bold; }
        table.data td.no { width: 15px; text-align: center; }
        table.data td.tgl { width: 50px; text-align: center; }
        table.data td.sign { width: 45px; }
        table.data td.empty-row { height: 120px; vertical-align: top; }

        .keterangan {
            margin-top: 6px;
            font-size: 6px;
        }
        .keterangan ol { margin: 0; padding-left: 9px; }

        .ttd {
            margin-top: 9px;
            width: 100%;
            border: none;
        }
        .ttd td { border: none; vertical-align: top; }
        .ttd .kanan { width: 110px; text-align: center; padding-left: auto; }
        .ttd .kanan .jabatan { font-weight: bold; }
        .ttd .kanan .space { height: 35px; }
        .ttd .kanan .nama { font-weight: bold; }
    </style>
</head>
<body>
    <div class="cetak-area">

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
                <th>NO</th>
                <th>TANGGAL</th>
                <th>KETERANGAN</th>
                <th>JUMLAH</th>
                <th>SIGN</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no empty-row">&nbsp;</td>
                <td class="tgl empty-row">&nbsp;</td>
                <td class="empty-row">&nbsp;</td>
                <td class="empty-row">&nbsp;</td>
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

    </div>

</body>
</html>
