@php
    use App\Utils\Tanggal;
@endphp
<div class="table-responsive" style="max-height:60vh">
    <table id="tblSiswaMenunggak" class="table table-bordered table-striped table-sm align-middle mb-0">
        <thead>
            <tr class="text-center">
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Nominal / Bulan</th>
                <th>Total Tunggakan</th>
                <th>Bulan Tunggakan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $r)
                <tr>
                    <td class="text-center">{{ $r->siswa->nisn }}</td>
                    <td>{{ $r->siswa->nama }}</td>
                    <td class="text-center">{{ $r->kode_kelas }}</td>
                    <td class="text-end">{{ \App\Utils\Angka::format($r->nominal_per_bulan, 2) }}</td>
                    <td class="text-end fw-semibold text-danger">
                        {{ \App\Utils\Angka::format($r->total_tunggakan, 2) }}
                    </td>
                    <td>
                        @foreach ($r->bulan_tunggakan->take(3) as $d)
                            <span class="badge bg-warning rounded-pill me-1">
                                {{ $d->translatedFormat('M Y') }}
                            </span>
                        @endforeach
                        @if ($r->bulan_tunggakan->count() > 3)
                            <span class="badge bg-secondary rounded-pill">+{{ $r->bulan_tunggakan->count() - 3 }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada siswa menunggak SPP.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
