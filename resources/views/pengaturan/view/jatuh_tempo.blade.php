<div class="card-body">
    <form action="/app/pengaturan/jatuh_tempo/{{ $profil->id }}" method="POST" class="text-start" id="FormJatuhTempo">
        @csrf
        @method('PUT')

        <div class="row align-items-center mb-3">
            <div class="col-md-6 mb-3">
                <div class="input-group input-group-outline {{ old('jatuh_tempo', $profil->jatuh_tempo) ? 'is-filled' : '' }}">
                    <label class="form-label">Tanggal Toleransi (1-31)</label>
                    <input type="number" min="1" max="31" name="jatuh_tempo" id="jatuh_tempo" value="{{ $profil->jatuh_tempo }}" class="form-control" required>
                </div>
                <small class="text-muted">Sistem akan mengingatkan pembuatan tunggakan pada tanggal ini setiap bulan.</small>
            </div>
        </div>
        <div class="d-flex justify-content-sm-end align-items-center mt-4 gap-2">
            <button class="btn bg-gradient-success px-4 mb-0 w-100 w-sm-auto" type="submit" id="SimpanJatuhTempo">
                <i class="fas fa-save me-1"></i> Simpan Jatuh Tempo
            </button>
        </div>
    </form>
</div>
