@php
    $initialInvoiceDate = old('tgl_invoice', optional($invoice->tgl_invoice)->format('Y-m-d')) ?? '';
    $initialStatus = old('status', $invoice->status ?? 'unpaid');
    $initialOwner = old('user_id', $invoice->user_id ?? '');
    $initialType = old('jenis_pembayaran', $invoice->jenis_pembayaran ?? '');
    $initialAmount = old('jumlah', $invoice->jumlah ?? '');
    $paymentTypes = [
        'Biaya Lisensi Instalasi',
        'Biaya Perpanjangan Maintenance dan Server',
        'Biaya Bimbingan Teknis',
        'Biaya Migrasi Ulang',
        'Biaya Aktivasi WA Gateway',
    ];
@endphp

<div class="sm:col-span-2">
    <label for="jenis_pembayaran" class="mb-1.5 block text-sm font-semibold text-slate-700">Payment type <span class="text-rose-500">*</span></label>
    <select id="jenis_pembayaran" name="jenis_pembayaran" required class="invoice-input select2 bg-white" data-placeholder="Pilih payment type">
        <option value="">Pilih payment type</option>
        @foreach ($paymentTypes as $pt)
            <option value="{{ $pt }}" @selected($initialType === $pt)>{{ $pt }}</option>
        @endforeach
    </select>
    @error('jenis_pembayaran')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
</div>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:col-span-2">
    <div>
        <label for="user_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Owner <span class="text-rose-500">*</span></label>
        <select id="user_id" name="user_id" required class="invoice-input select2 bg-white" data-placeholder="Pilih admin">
            <option value="">Pilih admin</option>
            @foreach ($admins as $a)
                <option value="{{ $a->id }}" @selected((string) $initialOwner === (string) $a->id)>{{ $a->nama_lengkap }} — {{ $a->email }}</option>
            @endforeach
        </select>
        @error('user_id')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">Status <span class="text-rose-500">*</span></label>
        <select id="status" name="status" required class="invoice-input select2 bg-white" data-placeholder="Pilih status">
            <option value="unpaid" @selected($initialStatus === 'unpaid')>Unpaid</option>
            <option value="paid" @selected($initialStatus === 'paid')>Paid</option>
        </select>
        @error('status')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="tgl_invoice" class="mb-1.5 block text-sm font-semibold text-slate-700">Invoice date <span class="text-rose-500">*</span></label>
        <input type="text" id="tgl_invoice" name="tgl_invoice" required value="{{ $initialInvoiceDate }}" class="invoice-input datepicker" placeholder="Pilih tanggal" autocomplete="off">
        @error('tgl_invoice')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="jumlah" class="mb-1.5 block text-sm font-semibold text-slate-700">Jumlah <span class="text-rose-500">*</span></label>
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-sm font-semibold text-slate-400">Rp</span>
            <input type="text" id="jumlah" name="jumlah" inputmode="decimal" required value="{{ $initialAmount }}" class="invoice-input nominal pl-10" placeholder="0.00" autocomplete="off">
        </div>
        @error('jumlah')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>
