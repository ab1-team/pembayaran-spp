@php
    use App\Utils\Tanggal;
@endphp
<div class="table-responsive" style="max-height:60vh">
    <table id="tblSiswaMenunggak" class="table table-bordered table-striped table-sm align-middle mb-0">
        <thead>
            <tr class="text-center">
                <th width="5%">No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Total Tagihan</th>
                <th>Bulan Tunggakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $s)
                @php
                    $total_tagihan = $s->getTransaksi->sum(fn($trx) => (float) $trx->getRawOriginal('jumlah'));
                    $bulanTunggakan = $s->getTransaksi
                        ->map(fn($trx) => Tanggal::namaBulan($trx->spp?->tanggal))
                        ->unique()->values();
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $s->nisn }}</td>
                    <td>{{ $s->nama }}</td>
                    <td class="text-center">{{ $s->kode_kelas }}</td>
                    <td class="text-end fw-semibold text-danger">
                        {{ \App\Utils\Angka::format($total_tagihan, 2) }}
                    </td>
                    <td>
                        @foreach ($bulanTunggakan->take(3) as $bulan)
                            <span class="badge bg-warning rounded-pill me-1">{{ $bulan }}</span>
                        @endforeach
                        @if ($bulanTunggakan->count() > 3)
                            <span class="badge bg-secondary rounded-pill">+{{ $bulanTunggakan->count() - 3 }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada siswa menunggak.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
