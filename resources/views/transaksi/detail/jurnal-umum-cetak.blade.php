@php
use App\Utils\Tanggal;
use App\Utils\Angka;
use App\Models\Profil;
@endphp

<div class="row mb-3">
    <div class="col-12 text-center">
        <h5 class="mb-0">Bukti Transaksi Jurnal Umum</h5>
        <small class="text-muted">{{ Profil::first()->nama ?? '' }}</small>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card m-0" style="border-radius:0">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="keuangan" class="table align-items-center table-striped">
                        <thead>
                            <tr>
                                <th width="6%" class="text-center align-middle">
                                    <div class="form-check d-flex justify-content-center m-0">
                                        <input class="form-check-input" type="checkbox" id="checkAllJurnal">
                                    </div>
                                </th>
                                <th width="6%">ID</th>
                                <th width="12%">Tanggal</th>
                                <th width="14%">Kode Akun</th>
                                <th width="14%">Nama Akun</th>
                                <th width="32%">Keterangan</th>
                                <th width="16%">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksi as $item)
                                <tr>
                                    <td class="text-center align-middle">
                                        <div class="form-check d-flex justify-content-center m-0">
                                            <input class="form-check-input checkItemJurnal" type="checkbox"
                                                value="{{ $item->id }}"
                                                data-jenis="{{ $item->jenis_dokumen ?? 'bm' }}">
                                        </div>
                                    </td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ Tanggal::tglIndo($item->tanggal_transaksi) }}</td>
                                    <td>
                                        <div class="small">
                                            <div>D: {{ $item->rekeningDebit->kode_akun ?? '-' }}</div>
                                            <div>K: {{ $item->rekeningKredit->kode_akun ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div>{{ $item->rekeningDebit->nama_akun ?? '-' }}</div>
                                            <div>{{ $item->rekeningKredit->nama_akun ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td>{{ $item->keterangan ?: '-' }}</td>
                                    <td class="text-end">
                                        {{ Angka::format($item->getRawOriginal('jumlah'), 0) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Tidak ada transaksi jurnal umum pada filter ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr class="fw-bold">
                                <td colspan="6" class="text-end">Jumlah</td>
                                <td class="text-end">{{ Angka::format($total, 0) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
