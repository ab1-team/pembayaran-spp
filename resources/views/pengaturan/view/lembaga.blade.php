<div class="card-body">
    <form action="/app/pengaturan/lembaga/{{ $profil->id }}" method="POST" class="text-start" id="FormLembaga">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('nama', $profil->nama) ? 'is-filled' : '' }}">
                    <label class="form-label">Nama Lembaga</label>
                    <input type="text" name="nama" id="nama" value="{{ $profil->nama }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('alamat', $profil->alamat) ? 'is-filled' : '' }}">
                    <label class="form-label">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ $profil->alamat }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('telpon', $profil->telpon) ? 'is-filled' : '' }}">
                    <label class="form-label">No Telepon</label>
                    <input type="text" name="telpon" id="telpon" value="{{ $profil->telpon }}" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('penanggung_jawab', $profil->penanggung_jawab) ? 'is-filled' : '' }}">
                    <label class="form-label">Penanggung Jawab</label>
                    <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="{{ $profil->penanggung_jawab }}" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column flex-sm-row justify-content-sm-end align-items-sm-center mt-4 gap-2">
            <small class="text-muted me-sm-auto mb-2 mb-sm-0"><i class="fas fa-info-circle me-1"></i> Perubahan akan langsung tersinkronisasi ke kwitansi & laporan.</small>
            <button class="btn bg-gradient-success px-4 mb-0 w-100 w-sm-auto" type="submit" id="SimpanLembaga">
                <i class="fas fa-save me-1"></i> Simpan Lembaga
            </button>
        </div>
    </form>
</div>
