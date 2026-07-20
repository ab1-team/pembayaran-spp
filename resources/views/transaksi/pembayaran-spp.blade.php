@extends('layouts.base')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body pt-2 pb-2 px-2">
                    <div class="row g-2 align-items-end">
                        <div class="col-12">
                            <input type="text" id="pembayaranSPP" placeholder="Cari NISN / Nama Siswa ...."
                                class="form-control form-search" autocomplete="off">
                        </div>
                </div>
            </div>
        </div>
        <div id="accordion" class="col-12">
            <div class="text-center text-muted py-5">
                <div class="spinner-border text-danger"></div>
                <p class="mt-2">Memuat form pembayaran...</p>
            </div>
        </div>
    </div>

    <form action="" method="post" id="FormHapusTransaksi">
        @method('DELETE')
        @csrf
    </form>
@endsection
@section('modal')
    <div class="modal fade modal-fullscreen" id="detail" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-person-lines-fill me-1"></i> Detail Transaksi Siswa
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detailContent">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-info-circle fs-2"></i>
                        <p class="mt-2">Silakan cari siswa terlebih dahulu</p>
                    </div>
                </div>

                <div class="modal-footer
                            flex-column flex-sm-row
                            justify-content-end gap-2
                            position-sticky bottom-0 bg-white border-top">
                    <button type="button" class="btn btn-secondary w-100 w-sm-auto" id="btnPrintAllDetail">
                        <i class="bi bi-printer-fill me-1"></i> Cetak Semua
                    </button>
                    <button type="button" class="btn btn-danger btn-close-modal w-100 w-sm-auto" id="btnTutupDetail">
                        <i class="bi bi-x-circle me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-fullscreen" id="CakboxAll" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-list-check me-1"></i> Pilih Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="CakboxAllContent">
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-info-circle fs-2"></i>
                        <p class="mt-2">Silakan cari siswa terlebih dahulu</p>
                    </div>
                </div>
                <div class="modal-footer
                            flex-column flex-sm-row
                            justify-content-end gap-2
                            position-sticky bottom-0 bg-white border-top">
                    <button type="button" class="btn btn-success w-100 w-sm-auto" id="btnCetak">
                        <i class="bi bi-printer-fill me-1"></i> Cetak
                    </button>
                    <button type="button" class="btn btn-danger btn-close-modal w-100 w-sm-auto" id="btnTutupCakbox">
                        <i class="bi bi-x-circle me-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let lastTransaksiIds = null;
        let formTagihanRequest = null;
        var numFormat = new Intl.NumberFormat('id-ID');
        var dataCustomer;

        function notifAlert({ icon = 'exclamation-triangle', title, why, solution, cls = 'alert-danger' }) {
            return `<div class="alert ${cls} text-start mb-0">
                <div class="fw-bold mb-1"><i class="bi bi-${icon} me-1"></i>${title}</div>
                <div class="small"><strong>Penyebab:</strong> ${why}</div>
                <div class="small mt-1"><strong>Solusi:</strong> ${solution}</div>
            </div>`;
        }

        //search
        $(function() {
            formTagihanBulanan();
        });

        $(document).on('click', '#closeRiwayat', function() {
            $('#riwayat-transaksi').addClass('d-none');
            $('#list-riwayat').empty();
        });

        $('#pembayaranSPP').typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'siswa',
            displayKey: 'name',
            templates: {
                empty: function(queryData) {
                    const q = (queryData && queryData.query) || '';
                    if (q.length < 2) return '';
                    const safe = $('<div>').text(q).html();
                    return `
                        <div class="p-3 small lh-sm">
                            <div class="fw-bold text-danger mb-1">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Siswa tidak ditemukan
                            </div>
                            <div class="text-muted">Pencarian: <strong>&quot;${safe}&quot;</strong></div>
                            <div class="text-muted mt-2">
                                <strong>Kemungkinan penyebab:</strong>
                                <ul class="ps-3 mb-1">
                                    <li>Ejaan nama atau NISN salah.</li>
                                    <li>Siswa belum punya <em>Anggota Kelas</em> ber-status Aktif.</li>
                                    <li>Siswa berstatus blokir / nonaktif.</li>
                                </ul>
                            </div>
                            <div class="text-muted">
                                <strong>Solusi:</strong> periksa ejaan, atau daftarkan siswa
                                via menu <em>Kelas &rarr; Anggota Kelas</em>.
                            </div>
                        </div>`;
                }
            },
            source: function(query, process) {
                if (query.length < 2) return process([]);
                $.get('/app/spp/CariSiswa', {
                    query: query
                }, function(result) {
                    if (!result || !result.length) return process([]);
                    process($.map(result, function(item) {
                        let inisial = item.package_inisial ? ' - ' + item.package_inisial :
                            '';
                        return {
                            name: item.nama + ' - ' + item.kode_kelas + inisial + ' [' +
                                item.nisn + ']',
                            item: item
                        };
                    }));
                });
            }
        }).bind('typeahead:selected', function(e, data) {
            formTagihanBulanan(data.item);
        });

        function formTagihanBulanan(siswa = null) {
            let idSiswa = siswa?.id_siswa ?? 0;

            formTagihanRequest?.abort();
            dataCustomer = null;
            formTagihanRequest = $.get('/app/spp/Pembayaran-spp/' + idSiswa, function(result) {
                $('#accordion').html(result.view ?? '');
                dataCustomer = siswa ? {
                    item: siswa,
                    rek_debit: result.rek_debit ?? null,
                    rek_kredit: result.rek_kredit ?? null
                } : null;
            }).fail(function(xhr, status) {
                if (status !== 'abort') {
                    $('#accordion').html(notifAlert({
                        title: 'Form pembayaran gagal dimuat',
                        why: 'koneksi terputus, server sibuk, atau data siswa sudah dihapus.',
                        solution: 'coba lagi beberapa saat. Bila gagal terus, pilih ulang siswa atau muat ulang halaman.'
                    }));
                }
            });
        }

        //detail siswa
        function loadTransaksiSiswa(mode = 'detail') {
            if (!dataCustomer || !dataCustomer.item) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Silakan cari siswa terlebih dahulu'
                });
                return;
            }

            let idSiswa = dataCustomer.item.id_siswa;

            if (mode === 'detail') {
                let modal = '#detail';
                let content = '#detailContent';
                $(content).html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-danger"></div>
                    <p class="mt-2">Memuat detail transaksi...</p>
                </div>
            `);
                $(modal).modal('show');
                $.get('/app/transaksi/pembayaranSPPDetail/' + idSiswa)
                    .done(function(res) {
                        $(content).html(res);
                    })
                    .fail(function() {
                        $(content).html(notifAlert({
                            title: 'Detail transaksi gagal dimuat',
                            why: 'siswa sudah dihapus / tidak ditemukan, atau terjadi gangguan jaringan.',
                            solution: 'tutup modal, pilih ulang siswa melalui pencarian, lalu buka kembali.'
                        }));
                    });
            }

            if (mode === 'printAll') {
                let modal = '#CakboxAll';
                let content = '#CakboxAllContent';
                $(content).html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-success"></div>
                    <p class="mt-2">Memuat transaksi untuk dicetak...</p>
                </div>
            `);
                $(modal).modal('show');
                $.get('/app/transaksi/pembayaran/printAll/' + idSiswa)
                    .done(function(res) {
                        $(content).html(res);
                    })
                    .fail(function() {
                        $(content).html(notifAlert({
                            title: 'Daftar cetak gagal dimuat',
                            why: 'siswa sudah dihapus / tidak ditemukan, atau terjadi gangguan jaringan.',
                            solution: 'tutup modal, pilih ulang siswa melalui pencarian, lalu buka kembali.'
                        }));
                    });
            }
        }

        $(document).on('click', '#btnDetailSiswa, #btnDetailSiswaTop', function() {
            loadTransaksiSiswa('detail');
        });

        $(document).on('click', '#btnPrintAllDetail', function() {
            loadTransaksiSiswa('printAll');
        });

        $(document).on('change', '#CakboxAllContent #checkAll', function() {
            $('#CakboxAllContent .checkItem').prop('checked', $(this).is(':checked'));
        });

        $(document).on('change', '#CakboxAllContent .checkItem', function() {
            $('#CakboxAllContent #checkAll').prop(
                'checked',
                $('#CakboxAllContent .checkItem:checked').length === $('#CakboxAllContent .checkItem').length
            );
        });

        $(document).on('click', '#btnCetak', function(e) {
            e.preventDefault();
            let ids = [];
            $('#CakboxAllContent .checkItem:checked').each(function() {
                ids.push($(this).val());
            });
            if (ids.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih minimal 1 transaksi untuk dicetak'
                });
                return;
            }
            let url = '/app/transaksi/pembayaran/printAllSelected?ids=' + ids.join(',');
            window.open(url, '_blank');
        });

        $(document).on('click', '#detail .btn-close-modal, #CakboxAll .btn-close-modal', function() {
            $('.modal.show').modal('hide');
        });

        $(document).on('click', '.SPPsimpan', function (e) {
            e.preventDefault();
            let $btn = $(this);

            $('.SPPsimpan').each(function () {
                if (!$(this).data('original-html')) {
                    $(this).data('original-html', $(this).html());
                }
            });
            $('.SPPsimpan').not($btn)
                .prop('disabled', true)
                .attr('aria-disabled', 'true');
            $btn
                .prop('disabled', true)
                .attr('aria-disabled', 'true')
                .html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');

                    let sumber_dana = $btn.data('sumber');
                    let form = $('#FormPembayaranSPP')[0];
                    let actionUrl = $('#FormPembayaranSPP').attr('action');
                    let formData = new FormData(form);
                    formData.append('sumber_dana', sumber_dana);

                    $.ajax({
                        type: 'POST',
                        url: actionUrl,
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (!result.success) {
                                Swal.fire({
                                    icon: 'error',
                                    title: result.msg || 'Transaksi ditolak',
                                    html: `
                                        <div class="small text-muted text-start mt-2">
                                            <div><strong>Penyebab:</strong> ${result.msg ? 'lihat pesan di atas.' : 'data tidak valid atau ditolak oleh sistem.'}</div>
                                            <div class="mt-1"><strong>Solusi:</strong> periksa kembali input (tanggal, jenis biaya, bulan SPP yang dicentang), lalu coba lagi.</div>
                                        </div>`,
                                    confirmButtonText: 'Oke'
                                });
                                return;
                            }
                            lastTransaksiIds = Array.isArray(result.id_transaksi)
                                ? result.id_transaksi.join(',')
                                : result.id_transaksi;

                            $('#kuitansi').removeClass('d-none');
                            $('#CetakPadaKartu').removeClass('d-none');
                            $('.SPPsimpan')
                    .prop('disabled', true)
                    .attr('aria-disabled', 'true')
                    .each(function () {
                        $(this).html($(this).data('original-html'));
                    });

                    let detailHtml = '';
                    if (result.detail_spp && result.detail_spp.length) {
                        let bulanAwal = result.detail_spp[0].bulan;
                        let bulanAkhir = result.detail_spp[result.detail_spp.length - 1].bulan;
                        let rangeBulan = bulanAwal === bulanAkhir
                            ? bulanAwal
                            : `${bulanAwal} – ${bulanAkhir}`;
                        detailHtml = `
                            <div class="text-start mb-2">
                                <strong>Periode:</strong> ${rangeBulan}
                            </div>
                        `;
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Transaksi Berhasil',
                        html: `
                            <div class="text-center mb-2">
                                ${result.keterangan}
                            </div>
                            ${detailHtml}
                        `,
                        timer: 2500,
                        showConfirmButton: false
                    });
                    $('#FormPembayaranSPP')[0].reset();
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Cek kembali input yang anda masukkan',
                        timer: 2500,
                        showConfirmButton: false
                    });
                },
                complete: function () {
                    if ($('#kuitansi').hasClass('d-none')) {
                        $('.SPPsimpan')
                            .prop('disabled', false)
                            .removeAttr('aria-disabled')
                            .each(function () {
                                $(this).html($(this).data('original-html'));
                            });
                    }
                }
            });
        });

        $(document).on('click', '#kuitansi', function () {
            if (!lastTransaksiIds) return;
            window.open(
                `/app/transaksi/kwitansi-spp?ids=${lastTransaksiIds}`,
                '_blank'
            );
        });

        $(document).on('click', '#CetakPadaKartu', function () {
            if (!lastTransaksiIds) return;
            window.open(
                `/app/transaksi/cetakPadaKartu?ids=${lastTransaksiIds}`,
                '_blank'
            );
        });

        function resetCetakButton() {
            lastTransaksiIds = null;
            $('#kuitansi, #CetakPadaKartu').addClass('d-none');
        }

        //hapus
        $(document).on('click', '.btnDelete', function(e) {
            e.preventDefault();

            var hapus_id = $(this).attr('data-id');
            var actionUrl = '/app/transaksi/pembayaranSPPDestroy/' + hapus_id;

            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Transaksi akan dibatalkan dan tagihan SPP dikembalikan ke belum lunas.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $('#FormHapusTransaksi');
                    $.ajax({
                        type: form.attr('method'),
                        url: actionUrl,
                        data: form.serialize(),
                        success: function(result) {
                            if (result.success) {
                                Swal.fire({
                                    title: "Berhasil!",
                                    text: result.msg,
                                    icon: "success",
                                    confirmButtonText: "Oke"
                                }).then((res) => {
                                    if (res.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: "Gagal",
                                    text: result.msg,
                                    icon: "info",
                                    confirmButtonText: "Oke"
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                title: "Kesalahan",
                                text: "Terjadi kesalahan pada server. Silakan coba lagi.",
                                icon: "error",
                                confirmButtonText: "Oke"
                            });
                        }
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire({
                        title: "Dibatalkan",
                        text: "Data tidak jadi dihapus.",
                        icon: "info",
                        confirmButtonText: "Oke"
                    });
                }
            });
        });
    </script>
@endsection
