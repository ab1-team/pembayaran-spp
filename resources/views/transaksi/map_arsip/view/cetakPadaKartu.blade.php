@php
    use App\Utils\Tanggal;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Kartu</title>

    <style>
        @media print {
            body {
                margin: 0;
            }
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
        }

        /* area kartu */
        .kartu {
            width: 100%;
            margin-top: 140px; /* atur sesuai posisi kartu fisik */
        }

        table.kartu-table {
            width: 100%;
        }
        table.kartu-table td {
            padding: 5px;
        }
        .center { text-align: center; }
        .right { text-align: right; }
    </style>
</head>
<body onload="window.print()">

<div class="kartu">
    <table class="kartu-table" width="100%" border="0" align="center" cellpadding="5" cellspacing="2">
        {{-- lompati baris yang sudah pernah dicetak sebelumnya pada kartu fisik --}}
        @for ($s = 0; $s < $jumlahTransaksi; $s++)
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
        @endfor

        @foreach ($transaksis as $i => $trx)
            <tr>
                <td width="7%" class="center">{{ $jumlahTransaksi + $i + 1 }}</td>
                <td width="30%">{{ Tanggal::tglIndo($trx->tanggal) }}</td>
                <td>
                    @if ($trx->spp)
                        {{ Tanggal::namabulan($trx->spp->tanggal) }}
                    @else
                        Daftar Ulang
                    @endif
                </td>
                <td width="20%" class="right">{{ \App\Utils\Angka::format($trx->getRawOriginal('jumlah'), 0) }}</td>
                <td width="15%" class="center">{{ $trx->id }}</td>
            </tr>
        @endforeach
    </table>
</div>

</body>
</html>
