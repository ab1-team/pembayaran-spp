@php
    use App\Utils\Tanggal;
    use App\Utils\Angka;
@endphp

<div class="card m-0" style="border-radius:0">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-center" width="6%">No</th>
                        <th width="28%">Nama</th>
                        <th width="16%">NISN</th>
                        <th width="20%">Bulan</th>
                        <th class="text-end" width="16%">Nominal</th>
                        <th class="text-center" width="14%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sppBelumLunas as $i => $item)
                        @php
                            $ts = \Carbon\Carbon::parse($item->tanggal);
                            $bulanSekarang = (int) date('n');
                            $tahunSekarang = (int) date('Y');
                            $isLewat =
                                (int) $ts->format('Y') < $tahunSekarang ||
                                ((int) $ts->format('Y') === $tahunSekarang && (int) $ts->format('n') <= $bulanSekarang);
                        @endphp
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->nisn ?: '-' }}</td>
                            <td>{{ Tanggal::namaBulan($item->tanggal) }} {{ $ts->format('Y') }}</td>
                            <td class="text-end">{{ Angka::format((int) $item->nominal, 0) }}</td>
                            <td class="text-center">
                                @if ($isLewat)
                                    <span class="badge bg-danger">Menunggak</span>
                                @else
                                    <span class="badge bg-secondary">Belum Jatuh Tempo</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center  fw-bold py-4">Tidak ada tagihan yang belum lunas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($sppBelumLunas->count())
                    <tfoot>
                        <tr class="fw-bold">
                            <td colspan="4" class="text-end">Total</td>
                            <td class="text-end">{{ Angka::format($sppBelumLunas->sum('nominal'), 0) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
