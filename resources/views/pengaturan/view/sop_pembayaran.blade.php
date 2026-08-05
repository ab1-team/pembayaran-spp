<div class="card-body">
    <form action="/app/pengaturan/sop-pembayaran/{{ $profil->id }}" method="POST" class="text-start" id="FormSoppembayaran">
        @csrf
        @method('PUT')

        <div class="alert alert-light border text-muted small mb-4" role="alert">
            <i class="fas fa-info-circle me-1 text-primary"></i>
            Tentukan jumlah bulan SPP yang harus dibayar terlebih dahulu sebelum siswa diizinkan mencetak kartu
            <strong>PTS</strong> (Pertengahan Semester) dan <strong>PAS</strong> (Penilaian Akhir Semester).
            Contoh: isi <strong>3</strong> maka siswa minimal harus membayar 3 bulan SPP sebelum bisa cetak kartu.
        </div>

        <div class="row align-items-center">
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('cetak_pts', $profil->cetak_pts ?? 3) !== null ? 'is-filled' : '' }}">
                    <label class="form-label">Minimal Bayar Sebelum Cetak PTS (Bulan)</label>
                    <input type="number" min="0" max="12" name="cetak_pts" id="cetak_pts"
                        value="{{ old('cetak_pts', $profil->cetak_pts ?? 3) }}"
                        class="form-control" required>
                </div>
                <small class="text-muted d-block mt-2">
                    Berlaku untuk cetak kartu <strong>PTS</strong>. Isi <strong>3</strong> artinya siswa harus bayar SPP 3 bulan terlebih dahulu.
                </small>
            </div>

            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('cetak_pas', $profil->cetak_pas ?? 3) !== null ? 'is-filled' : '' }}">
                    <label class="form-label">Minimal Bayar Sebelum Cetak PAS (Bulan)</label>
                    <input type="number" min="0" max="12" name="cetak_pas" id="cetak_pas"
                        value="{{ old('cetak_pas', $profil->cetak_pas ?? 3) }}"
                        class="form-control" required>
                </div>
                <small class="text-muted d-block mt-2">
                    Berlaku untuk cetak kartu <strong>PAS</strong>. Isi <strong>3</strong> artinya siswa harus bayar SPP 3 bulan terlebih dahulu.
                </small>
            </div>
        </div>

        <div class="d-flex justify-content-sm-end align-items-center mt-4 gap-2">
            <button class="btn bg-gradient-success px-4 mb-0 w-100 w-sm-auto" type="submit" id="SimpanSoppembayaran">
                <i class="fas fa-save me-1"></i> Simpan SOP Pembayaran
            </button>
        </div>
    </form>
</div>
