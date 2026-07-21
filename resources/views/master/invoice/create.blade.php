<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Invoice — {{ env('APP_NAME') }} Master</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Profil::logoUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html,body{font-family:'Inter',system-ui,sans-serif;background:#f6f7fb;}
        body{-webkit-tap-highlight-color:transparent;}
        .material-symbols-rounded{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24;}
        .form-floating>.form-control:focus~label,
        .form-floating>.form-control:not(:placeholder-shown)~label{opacity:.65;}
        .card-form{background:#fff;border:1px solid #e2e8f0;border-radius:1rem;box-shadow:0 1px 3px rgba(0,0,0,.04);}
    </style>
</head>
<body class="text-slate-800">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('master.partials.topbar')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

        <nav class="text-xs text-slate-500 mb-3">
            <a href="{{ route('master.invoice.index') }}" class="hover:text-indigo-600 text-decoration-none">Invoices</a>
            <span class="mx-1 text-slate-400">/</span>
            <span class="text-slate-700 font-medium">Create</span>
        </nav>

        <div class="flex items-center justify-between gap-3 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900">Create Invoice</h2>
                <p class="text-sm text-slate-500">Add a new invoice record.</p>
            </div>
            <a href="{{ route('master.invoice.index') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back
            </a>
        </div>

        <div class="card-form p-4 p-sm-5">
            @include('master.invoice._form')
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>
    <script>
        $(function () {
            // Select2
            $('.select2').each(function () {
                var ph = $(this).data('placeholder') || '';
                $(this).select2({ theme: 'bootstrap-5', width: '100%', placeholder: ph, allowClear: true });
            });

            // flatpickr
            flatpickr('.datepicker', { dateFormat: 'Y-m-d', allowInput: true });

            // Mask nominal (Rp)
            $('.nominal').maskMoney({
                prefix: 'Rp ',
                thousands: ',',
                decimal: '.',
                allowZero: true,
                allowNegative: false,
            });

            // For create page: empty initial value → no mask needed
            // For edit page: handled separately in edit.blade.php

            // Unmask before submit
            $('#invoice-form').on('submit', function () {
                $(this).find('.nominal').each(function () {
                    if (typeof $(this).maskMoney === 'function') {
                        $(this).val($(this).maskMoney('unmasked')[0]);
                    }
                });
            });
        });
    </script>

</body>
</html>
