<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — {{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Profil::logoUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body { font-family: 'Inter', system-ui, sans-serif; }
        body { -webkit-tap-highlight-color: transparent; background: #f8fafc; }
    </style>
</head>
<body class="min-h-screen text-slate-800">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('master.partials.topbar')

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        <header class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-indigo-600">Master Console</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Dashboard overview</h2>
                <p class="mt-1 text-sm text-slate-500">Monitor your latest invoices and payment status.</p>
            </div>
            <a href="{{ route('master.invoice.index') }}" class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
                View all invoices
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </header>

        @php
            $cards = [
                ['label' => 'Total invoices', 'value' => $stats['invoice_total'], 'icon' => 'document', 'color' => 'indigo'],
                ['label' => 'Paid invoices', 'value' => $stats['invoice_paid'], 'icon' => 'check', 'color' => 'emerald'],
                ['label' => 'Unpaid invoices', 'value' => $stats['invoice_open'], 'icon' => 'clock', 'color' => 'amber'],
                ['label' => 'Total amount', 'value' => 'Rp ' . number_format($stats['nominal_total'], 0, ',', '.'), 'icon' => 'money', 'color' => 'violet'],
            ];
        @endphp

        <section class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($cards as $card)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-600">
                            @if ($card['icon'] === 'document')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            @elseif ($card['icon'] === 'check')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @elseif ($card['icon'] === 'clock')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8v8m0 0v1m0-9V7m9 5a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            @endif
                        </div>
                    </div>
                    <p class="mt-4 text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                    <p class="mt-1 truncate text-2xl font-bold tracking-tight text-slate-900">{{ $card['value'] }}</p>
                </article>
            @endforeach
        </section>

        <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Recent invoices</h3>
                    <p class="mt-1 text-xs text-slate-500">The five latest invoices by invoice date.</p>
                </div>
                <a href="{{ route('master.invoice.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">View all</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-[680px] w-full text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3 font-semibold">Payment type</th>
                            <th class="px-5 py-3 font-semibold">Date</th>
                            <th class="px-5 py-3 font-semibold">Owner</th>
                            <th class="px-5 py-3 text-right font-semibold">Amount</th>
                            <th class="px-5 py-3 text-center font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($invoices as $invoice)
                            <tr class="transition hover:bg-slate-50">
                                <td class="whitespace-nowrap px-5 py-3 font-semibold text-slate-800">{{ $invoice->jenis_pembayaran }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">{{ $invoice->tgl_invoice?->format('d/m/Y') }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $invoice->user?->nama_lengkap ?? '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-right font-semibold tabular-nums text-slate-900">Rp {{ number_format($invoice->jumlah, 0, ',', '.') }}</td>
                                <td class="px-5 py-3 text-center">
                                    @if ($invoice->status === 'paid')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">Paid</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-semibold text-amber-700">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-14 text-center text-sm text-slate-400">No invoices yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <p class="mt-6 text-center text-xs text-slate-400">&copy; {{ date('Y') }} {{ env('APP_NAME') }}</p>
    </main>

    @if (session('success'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3000, timerProgressBar: true });</script>
    @endif
    @if (session('error'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 3000, timerProgressBar: true });</script>
    @endif
    @if (session('msg'))
        <script>Swal.fire({ toast: true, position: 'top-end', icon: @json(session('icon') ?? 'success'), title: @json(session('msg')), showConfirmButton: false, timer: 3000, timerProgressBar: true });</script>
    @endif
</body>
</html>
