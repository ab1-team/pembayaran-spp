<div class="card-body">
    <form action="/app/pengaturan/logo/{{ $profil->id }}"
      id="FormLogo"
      method="post"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-4 align-items-stretch">
        <div class="col-lg-5">
            <input type="file" id="logoInput" name="logo" accept="image/png,image/jpeg,image/jpg" class="file-input-hidden">
            <label for="logoInput" class="upload-zone" id="uploadZone" tabindex="0" role="button">
                <div class="upload-empty" id="uploadEmpty">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-arrow-up"></i>
                    </div>
                    <div class="fw-semibold mb-1">Klik atau seret logo ke sini</div>
                    <div class="text-xs text-muted">PNG, JPG, JPEG • Maks 2MB</div>
                </div>
                <img id="previewLogo" src="{{ $profil->logo ? asset('storage/logo/' . $profil->logo) : '' }}" alt="Logo Lembaga" />
                <div class="upload-overlay">
                    <div class="text-center">
                        <i class="fas fa-camera fa-2x mb-2"></i>
                        <div class="fw-semibold">Ganti Logo</div>
                    </div>
                </div>
            </label>
        </div>

        <div class="col-lg-7 d-flex flex-column">
            <div class="info-tile mb-3">
                <div class="info-label">Rekomendasi</div>
                <ul class="info-list">
                    <li><i class="fas fa-check-circle text-success me-1"></i> Format terbaik: <b>PNG transparan</b> atau <b>WebP</b></li>
                    <li><i class="fas fa-check-circle text-success me-1"></i> Ukuran ideal: <b>512×512 px</b> (persegi)</li>
                    <li><i class="fas fa-check-circle text-success me-1"></i> Digunakan di kwitansi & laporan</li>
                </ul>
            </div>

            <div class="mt-auto d-flex justify-content-end align-items-center gap-2">
                <button class="btn bg-gradient-success px-4 mb-0" type="submit" id="SimpanLogo">
                    <i class="fas fa-cloud-arrow-up me-1"></i> Unggah & Simpan
                </button>
            </div>
        </div>
    </div>
</form>
</div>

<style>
    .file-input-hidden {
        position: absolute;
        width: 1px; height: 1px;
        padding: 0; margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .upload-zone {
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }
</style>
<style>
    .upload-zone {
        position: relative;
        width: 100%;
        min-height: 260px;
        aspect-ratio: 1 / 1;
        max-height: 320px;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        cursor: pointer;
        overflow: hidden;
        background:
            repeating-linear-gradient(45deg, #f8fafc 0 10px, #ffffff 10px 20px);
        transition: border-color .25s ease, transform .25s ease, box-shadow .25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .upload-zone:hover,
    .upload-zone:focus-visible {
        border-color: #37d17c;
        box-shadow: 0 0 0 4px rgba(55, 209, 124, .15);
        outline: none;
    }
    .upload-zone.drag-over {
        border-color: #37d17c;
        background:
            repeating-linear-gradient(45deg, #ecfdf5 0 10px, #ffffff 10px 20px);
        transform: scale(1.01);
    }
    .upload-zone img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #fff;
        display: none;
        padding: 12px;
    }
    .upload-zone.has-image img { display: block; }
    .upload-zone.has-image .upload-empty { display: none; }

    .upload-empty {
        text-align: center;
        color: #475569;
        padding: 16px;
    }
    .upload-icon {
        width: 56px; height: 56px;
        border-radius: 50%;
        background: rgba(55, 209, 124, .12);
        color: #37d17c;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        margin: 0 auto 12px;
    }

    .upload-overlay {
        position: absolute; inset: 0;
        background: rgba(15, 23, 42, .55);
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        opacity: 0;
        transition: opacity .25s ease;
        pointer-events: none;
    }
    .upload-zone.has-image:hover .upload-overlay,
    .upload-zone:focus-within .upload-overlay { opacity: 1; }

    .info-tile {
        background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%);
        border: 1px solid rgba(55, 209, 124, .25);
        border-radius: 12px;
        padding: 14px 16px;
    }
    .info-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #0f766e;
        font-weight: 700;
        margin-bottom: 6px;
    }
    .info-list {
        list-style: none; padding: 0; margin: 0;
        font-size: 13px; color: #334155;
    }
    .info-list li { padding: 2px 0; }
</style>

<script>
    const zone = document.getElementById('uploadZone');
    const input = document.getElementById('logoInput');
    const preview = document.getElementById('previewLogo');
    const hasImage = !!preview.getAttribute('src');

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            zone.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    }

    input.addEventListener('change', e => showPreview(e.target.files[0]));

    ['dragenter', 'dragover'].forEach(ev =>
        zone.addEventListener(ev, e => { e.preventDefault(); zone.classList.add('drag-over'); })
    );
    ['dragleave', 'drop'].forEach(ev =>
        zone.addEventListener(ev, e => { e.preventDefault(); zone.classList.remove('drag-over'); })
    );
    zone.addEventListener('drop', e => {
        const f = e.dataTransfer.files[0];
        if (f) {
            const dt = new DataTransfer();
            dt.items.add(f);
            input.files = dt.files;
            showPreview(f);
        }
    });
    zone.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
    });

    if (hasImage) zone.classList.add('has-image');
</script>
