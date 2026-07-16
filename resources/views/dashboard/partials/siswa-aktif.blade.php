<div class="table-responsive" style="max-height:60vh">
    <table id="tblSiswaAktif" class="table table-bordered table-striped table-sm align-middle mb-0">
        <thead>
            <tr class="text-center">
                <th width="5%">No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tahun Akademik</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $s)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $s->nisn }}</td>
                    <td>{{ $s->nama }}</td>
                    <td class="text-center">{{ $s->kode_kelas }}</td>
                    <td class="text-center">{{ $s->kode_jurusan }}</td>
                    <td class="text-center">{{ $s->tahun_akademik }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Tidak ada siswa aktif.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
