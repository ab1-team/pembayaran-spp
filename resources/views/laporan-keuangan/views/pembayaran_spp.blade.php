<title>{{ $title }}</title>
@extends('laporan-keuangan.layout.base')

@section('content')
    <table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:15px;">
        <tr>
            <td align="center" style="padding:0;">
                <div style="font-size:20px; font-weight:bold; margin:0; padding:0; line-height:1.1;">
                    {{ $title }}
                    @if (!empty($kelas))
                        Kelas {{ $kelas->kode_kelas }}
                    @endif
                </div>

                <div style="font-size:16px; font-weight:bold; margin:2px 0 0 0; padding:0; line-height:1.1;">
                    Periode
                    {{ $periode['awal']->translatedFormat('d F Y') }}
                    s.d.
                    {{ $periode['akhir']->translatedFormat('d F Y') }}
                </div>
            </td>

        </tr>
    </table>

    <table width="100%" cellpadding="3" cellspacing="0" style="border-collapse:collapse; font-size:9px;">

        <thead>
            <tr style="text-align:center; font-weight:bold;">
                <th rowspan="3" style="border:1px solid #000; width:3%;">No</th>
                <th rowspan="3" style="border:1px solid #000; width:8%;">NISN</th>
                <th rowspan="3" style="border:1px solid #000; width:18%;">Nama Siswa</th>

                <th rowspan="3" style="border:1px solid #000; width:7%;">Target / Bulan</th>

                <th colspan="{{ count($bulanList) * 2 }}" style="border:1px solid #000;">
                    Realisasi Per Bulan
                </th>

                <th colspan="3" style="border:1px solid #000;">
                    Akumulasi
                </th>

                <th rowspan="3" style="border:1px solid #000; width:10%;">Keterangan</th>
            </tr>

            <tr style="text-align:center; font-weight:bold;">
                @foreach ($bulanList as $bln)
                    <th colspan="2" style="border:1px solid #000;">
                        {{ $bln->translatedFormat('M Y') }}
                    </th>
                @endforeach

                <th rowspan="2" style="border:1px solid #000; width:6%;">Target s.d. Saat Ini</th>
                <th rowspan="2" style="border:1px solid #000; width:6%;">Bayar s.d. Periode Ini</th>
                <th rowspan="2" style="border:1px solid #000; width:6%;">Sisa</th>
            </tr>

            <tr style="text-align:center; font-weight:bold;">
                @foreach ($bulanList as $bln)
                    <th style="border:1px solid #000; width:3%;">Status</th>
                    <th style="border:1px solid #000; width:4%;">Bayar</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($anggotaKelas as $i => $row)
                <tr>
                    <td style="border:1px solid #000; text-align:center;">{{ $i + 1 }}</td>

                    <td style="border:1px solid #000; text-align:center;">
                        {{ $row->getSiswa->nisn ?? '-' }}
                    </td>

                    <td style="border:1px solid #000;">
                        {{ $row->getSiswa->nama ?? '-' }}
                    </td>

                    <td style="border:1px solid #000; text-align:right;">
                        {{ \App\Utils\Angka::format($row->per_bulan, 2) }}
                    </td>

                    @foreach ($row->bulan_list as $b)
                        <td style="border:1px solid #000; text-align:center;
                            color: {{ $b->status === 'L' ? 'black' : ($b->status === 'B' ? 'red' : '#888') }};">
                            @if ($b->status === 'L')
                                L
                            @elseif ($b->status === 'B')
                                B
                            @else
                                -
                            @endif
                        </td>
                        <td style="border:1px solid #000; text-align:right;">
                            {{ $b->bayar > 0 ? \App\Utils\Angka::format($b->bayar, 2) : '-' }}
                        </td>
                    @endforeach

                    <td style="border:1px solid #000; text-align:right;">
                        {{ \App\Utils\Angka::format($row->target_sd_saat_ini, 2) }}
                    </td>

                    <td style="border:1px solid #000; text-align:right;">
                        {{ \App\Utils\Angka::format($row->sd_periode_ini, 2) }}
                    </td>

                    <td style="border:1px solid #000; text-align:right;
                        color: {{ $row->sisa > 0 ? 'red' : 'black' }};">
                        @if ($row->sisa > 0)
                            {{ \App\Utils\Angka::format($row->sisa, 2) }}
                        @else
                            -
                        @endif
                    </td>

                    <td style="border:1px solid #000; text-align:center;
                        color: {{ $row->sisa > 0 ? 'red' : 'black' }};">
                        @if ($row->sisa > 0)
                            Belum Lunas
                        @else
                            Lunas
                        @endif
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="{{ 5 + count($bulanList) * 2 + 4 }}" style="border:1px solid #000; text-align:center; font-style:italic;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
@endsection
