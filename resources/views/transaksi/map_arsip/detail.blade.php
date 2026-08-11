@php
    use App\Utils\Tanggal;
    // Anda bisa mengubah kode warna di bawah ini sesuai keinginan (Hex, RGB, atau nama warna CSS)
    $warnaHeader = '#6c757d'; // Contoh: Biru (#007bff), Hijau (#28a745), Ungu (#6f42c1), dll.
@endphp

<div class="row">
    <div class="col-12">
        <div class="card m-0" style="border-radius:0">
            <div class="card-header p-3">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <select id="filter_tahun_akademik" class="form-control form-control-sm select2"
                        style="min-width:200px;">
                        <option value="">Semua Tahun Akademik</option>
                    </select>
                </div>
            </div>

            <div class="card-body pt-2">
                <div class="table-responsive">
                    <table id="keuangan" class="table align-items-center table-striped">
                        <thead>
                            <!-- Warna background dan teks diatur secara dinamis melalui variabel PHP di atas -->
                            <tr align="center" style="background-color: {{ $warnaHeader }}; color: #ffffff;">
                                <th width="6%" style="color: #ffffff;">ID</th>
                                <th width="12%" style="color: #ffffff;">Tanggal Trx</th>
                                {{-- <th width="14%" style="color: #ffffff;">Kode Akun</th> --}}
                                <th width="36%" style="color: #ffffff;">Keterangan</th>
                                <th width="12%" style="color: #ffffff;">Nominal</th>
                                <th width="20%" style="color: #ffffff;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa->getTransaksi as $item)
                                <tr>
                                    <td align="center">{{ $item->id }}</td>
                                    <td align="center">
                                        {{ Tanggal::tglIndo($item->tanggal_transaksi) }}
                                    </td>
                                    {{-- <td align="center">
                                        <div class="small">
                                            <div>D: {{ $item->rekeningDebit->kode_akun ?? '-' }}</div>
                                            <div>K: {{ $item->rekeningKredit->kode_akun ?? '-' }}</div>
                                        </div>
                                    </td> --}}
                                    <td>{{ $item->keterangan }}</td>
                                    <td align="right" style="padding-right: 10px;">
                                        {{ \App\Utils\Angka::format($item->getRawOriginal('jumlah'), 0) }}
                                    </td>
                                    <td class="text-center text-nowrap">
                                        <div class="d-inline-flex gap-1">
                                            <a href="/app/transaksi/kwitansi-spp?ids={{ $item->id }}"
                                                target="_blank" class="btn btn-secondary btn-compact"
                                                title="Cetak Kwitansi">
                                                <i class="material-symbols-rounded">print</i>
                                            </a>
                                            <a href="/app/transaksi/cetakPadaKartu?ids={{ $item->id }}"
                                                target="_blank" class="btn btn-secondary btn-compact"
                                                title="Cetak Pada Kartu">
                                                <i class="material-symbols-rounded">credit_card</i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-compact btnDelete"
                                                data-id="{{ $item->id }}">
                                                <i class="material-symbols-rounded">delete</i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Tidak ada transaksi SPP
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Jumlah</td>
                                <td class="text-end">
                                    {{ \App\Utils\Angka::format($siswa->getTransaksi->sum(fn($t) => $t->getRawOriginal('jumlah')), 0) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        let siswaId = @json($siswa->id);
        let currentTahun = @json($tahunAkademik ?? '');
        let $sel = $('#filter_tahun_akademik');

        if (!$sel.length) return;

        let $modal = $sel.closest('.modal');

        function initSelect2() {
            if (!$.fn.select2) return;
            $sel.select2({
                theme: 'bootstrap-5',
                width: '250px',
                dropdownParent: $modal.length ? $modal : document.body
            });
        }

        $.getJSON('/app/siswa/listTahun', function(data) {
            $sel.empty().append('<option value="">Semua Tahun Akademik</option>');
            data.forEach(function(t) {
                let selected = (currentTahun && t.nama_tahun === currentTahun) ? 'selected' : '';
                $sel.append(`<option value="${t.nama_tahun}" ${selected}>${t.nama_tahun}</option>`);
            });
            initSelect2();
        });

        $sel.on('change', function() {
            let tahun = $(this).val() || '';
            let url = '/app/transaksi/pembayaranSPPDetail/' + siswaId +
                (tahun ? '?tahun_akademik=' + encodeURIComponent(tahun) : '');

            let content = '#detailContent';
            if ($(content).length) {
                $(content).html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-danger"></div>
                        <p class="mt-2">Memuat detail transaksi...</p>
                    </div>
                `);
                $.get(url)
                    .done(function(res) {
                        $(content).html(res);
                    })
                    .fail(function() {
                        $(content).html(
                            '<div class="alert alert-danger m-3">Gagal memuat detail.</div>');
                    });
            } else {
                window.location.href = url;
            }
        });
    })();
</script>

<style>
    #detail .select2-container,
    #detail .select2-container--bootstrap-5 {
        z-index: 10060 !important;
    }

    #detail .select2-container--bootstrap-5 .select2-dropdown {
        z-index: 10061 !important;
    }
</style>
