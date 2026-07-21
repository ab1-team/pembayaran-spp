@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-body px-4 py-3">
                    <div class="table-responsive">
                        <table id="invoices" class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>Jenis Pembayaran</th>
                                    <th style="width: 130px;">Tgl Invoice</th>
                                    <th style="width: 130px;">Tgl Lunas</th>
                                    <th style="width: 110px;">Status</th>
                                    <th class="text-end" style="width: 160px;">Jumlah</th>
                                    <th class="text-center" style="width: 90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $i => $row)
                                    <tr class="row-invoice" style="cursor: pointer;" data-href="{{ route('app.pengaturan.invoice.print', $row->id) }}">
                                        <td class="text-center text-muted">{{ $i + 1 }}</td>
                                        <td class="fw-semibold">{{ $row->jenis_pembayaran ?? '—' }}</td>
                                        <td class="text-nowrap">{{ $row->tgl_invoice?->format('d/m/Y') ?? '—' }}</td>
                                        <td class="text-nowrap">{{ $row->tgl_lunas?->format('d/m/Y') ?? '—' }}</td>
                                        <td>
                                            @php
                                                $badge = match ($row->status) {
                                                    'paid'   => 'success',
                                                    'unpaid' => 'warning',
                                                    default  => 'secondary',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $badge }}">{{ ucfirst($row->status ?? '—') }}</span>
                                        </td>
                                        <td class="text-end fw-semibold text-nowrap">Rp {{ number_format((float) $row->jumlah, 0, ',', '.') }}</td>
                                        <td class="text-center td-action">
                                            <a href="{{ route('app.pengaturan.invoice.print', $row->id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                <i class="material-icons align-middle" style="font-size:18px;">picture_as_pdf</i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Belum ada invoice.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#invoices').DataTable({
                paging: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                searching: true,
                info: true,
                autoWidth: true,
                scrollX: true,
                order: [[2, 'desc']],
                language: {
                    lengthMenu: 'Tampilkan _MENU_ data',
                    search: 'Cari:',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' }
                },
                columnDefs: [
                    { orderable: false, searchable: false, targets: [0, 6] }
                ]
            });

            $('#invoices').on('click', 'tr.row-invoice', function (e) {
                if ($(e.target).closest('a, .btn').length) return;
                const href = $(this).data('href');
                if (href) window.open(href, '_blank');
            });
        });
    </script>
@endsection
