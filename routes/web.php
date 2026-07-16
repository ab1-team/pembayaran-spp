<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\JenisBiayaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\TahunAkademikController;
use App\Http\Controllers\JenisPembayaranController;
use App\Http\Controllers\RekeningController;

Route::get('/', [AuthController::class, 'index'])->name('login');

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');

Route::get('/link', function () {
    $target = __DIR__ . '/../storage/app/public';
    $shortcut = __DIR__ . '/../public/storage';

    try {
        symlink($target, $shortcut);
        return response()->json("Symlink created successfully.");
    } catch (\Exception $e) {
        return response()->json("Failed to create symlink: " . $e->getMessage());
    }
});

Route::group(['middleware' => ['auth'], 'prefix' => 'app'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('app.dashboard');

    Route::put('/profile/update/{id}', [ProfilController::class, 'update']);
    Route::get('/profile', [ProfilController::class, 'index']);

    Route::get('/system/generate-tunggakan/{time}', [SystemController::class, 'GenerateTunggakan']);

    Route::get('/Transaksi/pembayaran-spp', [TransaksiController::class, 'pembayaranSPP']);
    Route::get('/transaksi/daftar-inventaris', [TransaksiController::class, 'daftarInventaris']);
    Route::post('/transaksi/ProsesPembayaran', [TransaksiController::class, 'pembayaranSPPStore']);
    Route::get('/transaksi/kwitansi-spp', [TransaksiController::class, 'pembayaranSPPPrint']);
    Route::get('/transaksi/pembayaran/printAllSelected', [TransaksiController::class, 'printAllSelected']);
    Route::get('/transaksi/pembayaran/printAll/{id}', [TransaksiController::class, 'pembayaranSPPPrintAll']);
    Route::get('/transaksi/pembayaranSPPDetail/{id}', [TransaksiController::class, 'pembayaranSPPDetail']);
    Route::get('/transaksi/cetakPadaKartu', [TransaksiController::class, 'CetakPadaKartu']);
    Route::delete('/transaksi/pembayaranSPPDestroy/{Transaksi}', [TransaksiController::class, 'pembayaranSPPDestroy']);
    Route::resource('/Transaksi', TransaksiController::class);

    Route::resource('/jenis-biaya', JenisBiayaController::class);
    Route::get('/jenis-biaya-create-form', [JenisBiayaController::class, 'createForm']);
    Route::get('/jenis-biaya-edit-form/{jenis_biaya}', [JenisBiayaController::class, 'editForm']);
    Route::get('/spp/CariSiswa', [SppController::class, 'CariSiswaAktif']);
    Route::get('/spp/Pembayaran-spp/{id}', [SppController::class, 'spp']);
    Route::resource('/spp', SppController::class);

    Route::get('/pengaturan/sop', [PengaturanController::class, 'sop']);
    Route::get('/pengaturan/coa', [PengaturanController::class, 'coa']);
    Route::get('/pengaturan/ttd-pelaporan', [PengaturanController::class, 'ttdPelaporan']);
    Route::post('/pengaturan/simpan/ttd-pelaporan', [PengaturanController::class, 'ttdPelaporanStore']);
    Route::put('/pengaturan/lembaga/{id}', [PengaturanController::class, 'lembaga']);
    Route::put('/pengaturan/logo/{id}', [PengaturanController::class, 'logo']);
    Route::put('/pengaturan/jatuh_tempo/{id}', [PengaturanController::class, 'jatuhTempo']);
    Route::resource('/pengaturan', PengaturanController::class);

    Route::get('/siswa/listTahun', [SiswaController::class, 'listTahun']);
    Route::get('/siswa/listKelas', [SiswaController::class, 'listKelas']);
    Route::get('/siswa/printSiswa', [SiswaController::class, 'printSiswa']);
    Route::post('/siswa/mutasi', [SiswaController::class, 'mutasi']);
    Route::get('/siswa/riwayatPembayaran/{id}', [SiswaController::class, 'riwayatPembayaran']);
    Route::resource('/siswa', SiswaController::class);

    Route::get('/laporan-keuangan', [LaporanController::class, 'index']);

    Route::get('/dashboard/siswa-aktif', [DashboardController::class, 'siswaAktifTable']);
    Route::get('/dashboard/siswa-menunggak', [DashboardController::class, 'siswaMenunggakTable']);

    Route::get('/pelaporan/preview', [LaporanController::class, 'preview']);

    Route::get('/pelaporan/sub_laporan/{file}', [LaporanController::class, 'subLaporan']);

    Route::resource('jurusan', JurusanController::class)
        ->parameters(['jurusan' => 'jurusan'])
        ->names('app.jurusan');

    Route::resource('kelas', KelasController::class)
        ->parameters(['kelas' => 'kelas'])
        ->names('app.kelas');

    Route::resource('kurikulum', KurikulumController::class)
        ->parameters(['kurikulum' => 'kurikulum'])
        ->names('app.kurikulum');

    Route::resource('ruangan', RuanganController::class)
        ->parameters(['ruangan' => 'ruangan'])
        ->names('app.ruangan');

    Route::resource('tahun-akademik', TahunAkademikController::class)
        ->parameters(['tahun-akademik' => 'tahun_akademik'])
        ->names('app.tahun-akademik');

    Route::post('tahun-akademik/{tahun_akademik}/aktifkan', [TahunAkademikController::class, 'aktifkan'])
        ->name('app.tahun-akademik.aktifkan');

    Route::resource('jenis-pembayaran', JenisPembayaranController::class)
        ->parameters(['jenis-pembayaran' => 'jenis_pembayaran'])
        ->names('app.jenis-pembayaran');

    Route::get('coa', [RekeningController::class, 'tree'])->name('app.coa');
    Route::post('coa/{rekening}/nonaktifkan', [RekeningController::class, 'nonaktifkan'])->name('app.coa.nonaktifkan');
    Route::post('coa/{rekening}/aktifkan', [RekeningController::class, 'aktifkan'])->name('app.coa.aktifkan');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});




