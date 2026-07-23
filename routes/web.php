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
use App\Http\Controllers\Master\MasterAuthController;
use App\Http\Controllers\Master\MasterDashboardController;
use App\Http\Controllers\Master\AdminInvoiceController;
use App\Http\Controllers\Master\HakAksesController as MasterHakAksesController;

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

Route::get('/master', [MasterAuthController::class, 'index'])->name('master.login');
Route::post('/master/login', [MasterAuthController::class, 'login'])->name('master.auth');
Route::post('/master/logout', [MasterAuthController::class, 'logout'])->name('master.logout');

Route::group(['middleware' => ['auth:master'], 'prefix' => 'master'], function () {
    Route::get('/dashboard', [MasterDashboardController::class, 'index'])->name('master.dashboard');
    Route::get('/hak-akses', [MasterHakAksesController::class, 'index'])->name('master.hak-akses');
    Route::post('/hak-akses', [MasterHakAksesController::class, 'store'])->name('master.hak-akses.store');
    Route::put('/hak-akses/{user}', [MasterHakAksesController::class, 'update'])->name('master.hak-akses.update');
    Route::get('/invoice/data', [AdminInvoiceController::class, 'data'])->name('master.invoice.data');
    Route::get('/invoice/{invoice}/print', [AdminInvoiceController::class, 'print'])->name('master.invoice.print');

    Route::get('/transaksi', [\App\Http\Controllers\Master\TransaksiController::class, 'index'])->name('master.transaksi.index');
    Route::get('/transaksi/data', [\App\Http\Controllers\Master\TransaksiController::class, 'index'])->name('master.transaksi.data');
    Route::get('/transaksi/{invoice}/payment', [\App\Http\Controllers\Master\TransaksiController::class, 'paymentForm'])->name('master.transaksi.paymentForm');
    Route::post('/transaksi', [\App\Http\Controllers\Master\TransaksiController::class, 'store'])->name('master.transaksi.store');
    Route::resource('invoice', AdminInvoiceController::class)
        ->only(['index', 'store', 'destroy'])
        ->names('master.invoice');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'app'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('app.dashboard');

    Route::put('/profile/update/{id}', [ProfilController::class, 'update']);
    Route::get('/profile', [ProfilController::class, 'index']);

    Route::get('/system/generate-tunggakan', [SystemController::class, 'GenerateTunggakan']);
    Route::get('/system/piutang-status', [SystemController::class, 'piutangStatus']);

    Route::get('/Transaksi/pembayaran-spp', [TransaksiController::class, 'pembayaranSPP']);
    Route::get('/transaksi/daftar-inventaris', [TransaksiController::class, 'daftarInventaris']);
    Route::post('/transaksi/ProsesPembayaran', [TransaksiController::class, 'pembayaranSPPStore']);
    Route::get('/transaksi/kwitansi-spp', [TransaksiController::class, 'pembayaranSPPPrint']);
    Route::get('/transaksi/pembayaran/printAllSelected', [TransaksiController::class, 'printAllSelected']);
    Route::get('/transaksi/pembayaran/printAll/{id}', [TransaksiController::class, 'pembayaranSPPPrintAll']);
    Route::get('/transaksi/pembayaranSPPDetail/{id}', [TransaksiController::class, 'pembayaranSPPDetail']);
    Route::get('/transaksi/cetakPadaKartu', [TransaksiController::class, 'CetakPadaKartu']);
    Route::get('/transaksi/cetak-kartu-spp/{id}', [TransaksiController::class, 'cetakKartuSpp']);
    Route::get('/transaksi/cetak-kartu-ujian/{id}/{jenis}', [TransaksiController::class, 'cetakKartuUjian'])
        ->where('jenis', 'uts1|uts2|pas1|pas2');
    Route::delete('/transaksi/pembayaranSPPDestroy/{Transaksi}', [TransaksiController::class, 'pembayaranSPPDestroy']);
    Route::resource('/Transaksi', TransaksiController::class);
    Route::get('/Transaksi/jurnal-umum/data', [TransaksiController::class, 'jurnalUmumData'])->name('Transaksi.jurnalUmumData');
    Route::get('/Transaksi/jurnal-umum/detail', [TransaksiController::class, 'jurnalUmumDetail'])->name('Transaksi.jurnalUmumDetail');
    Route::get('/Transaksi/jurnal-umum/cetak', [TransaksiController::class, 'jurnalUmumCetak'])->name('Transaksi.jurnalUmumCetak');
    Route::get('/Transaksi/jurnal-umum/printDokumen/{jenis}', [TransaksiController::class, 'jurnalUmumPrintDokumen'])->name('Transaksi.jurnalUmumPrintDokumen');
    Route::delete('/Transaksi/jurnal-umum/{transaksi}', [TransaksiController::class, 'jurnalUmumDestroy'])->name('Transaksi.jurnalUmumDestroy');

    Route::resource('/jenis-biaya', JenisBiayaController::class);
    Route::get('/jenis-biaya-create-form', [JenisBiayaController::class, 'createForm']);
    Route::get('/jenis-biaya-edit-form/{jenis_biaya}', [JenisBiayaController::class, 'editForm']);
    Route::get('/spp/CariSiswa', [SppController::class, 'CariSiswaAktif']);
    Route::get('/spp/Pembayaran-spp/{id}', [SppController::class, 'spp']);
    Route::resource('/spp', SppController::class);

    Route::get('/pengaturan/sop', [PengaturanController::class, 'sop']);
    Route::get('/pengaturan/coa', [PengaturanController::class, 'coa']);
    Route::get('/pengaturan/ttd-pelaporan', [PengaturanController::class, 'ttdPelaporan']);
    Route::get('/pengaturan/invoice', [PengaturanController::class, 'invoice'])->name('app.pengaturan.invoice');
    Route::get('/pengaturan/invoice/data', [PengaturanController::class, 'invoice'])->name('app.pengaturan.invoice.data');
    Route::get('/pengaturan/invoice/{invoice}/print', [PengaturanController::class, 'invoicePrint'])->name('app.pengaturan.invoice.print');
    Route::post('/pengaturan/simpan/ttd-pelaporan', [PengaturanController::class, 'ttdPelaporanStore']);
    Route::put('/pengaturan/lembaga/{id}', [PengaturanController::class, 'lembaga']);
    Route::put('/pengaturan/logo/{id}', [PengaturanController::class, 'logo']);
    Route::put('/pengaturan/jatuh_tempo/{id}', [PengaturanController::class, 'jatuhTempo']);
    Route::resource('/pengaturan', PengaturanController::class);

    Route::get('/siswa/listTahun', [SiswaController::class, 'listTahun']);
    Route::get('/siswa/listKelas', [SiswaController::class, 'listKelas']);
    Route::get('/siswa/printSiswa', [SiswaController::class, 'printSiswa']);
    Route::get('/siswa/nominal-spp', [SiswaController::class, 'getNominalSpp']);
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




