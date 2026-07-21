<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hak Akses — {{ env('APP_NAME') }} Master</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Profil::logoUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html, body { font-family: 'Inter', system-ui, sans-serif; }
        body { -webkit-tap-highlight-color: transparent; background: #f8fafc; }
        .invoice-input { width: 100%; min-height: 36px; border: 1px solid #cbd5e1; border-radius: .5rem; background: #fff; padding: .4rem .75rem; font-size: .8125rem; color: #1e293b; transition: border-color .15s ease, box-shadow .15s ease; }
        .invoice-input::placeholder { color: #94a3b8; }
        .invoice-input:focus { border-color: #6366f1; outline: none; box-shadow: 0 0 0 4px rgba(99, 102, 241, .15); }
        .menu-scroll { max-height: 42vh; overflow-y: auto; }
        .menu-scroll::-webkit-scrollbar { width: 8px; }
        .menu-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .menu-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .select2-container { width: 100% !important; }
        .select2-container--bootstrap-5 .select2-selection { min-height: 36px; border-color: #cbd5e1; border-radius: .5rem; padding: .25rem .75rem; font-size: .8125rem; }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered { padding: .125rem 1.5rem .125rem 0; color: #1e293b; line-height: 1.5rem; }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow { top: 6px; right: 8px; }
        .select2-container--bootstrap-5.select2-container--focus .select2-selection,
        .select2-container--bootstrap-5.select2-container--open .select2-selection { border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99, 102, 241, .15); }
        .select2-container--bootstrap-5 .select2-dropdown { border-color: #cbd5e1; border-radius: .75rem; overflow: hidden; }
        .modal-scroll .select2-container--open { z-index: 70; }
        .modal-scroll .select2-container--bootstrap-5 .select2-dropdown { z-index: 70; }
        .cb { accent-color: #4f46e5; cursor: pointer; }
        details > summary { list-style: none; cursor: pointer; }
        details > summary::-webkit-details-marker { display: none; }
        details > summary::marker { display: none; }
        details[open] .chev { transform: rotate(90deg); }
        .chev { transition: transform .18s ease; }
        .menu-row:hover { background: #f8fafc; }
        .group-card { box-shadow: 0 1px 0 rgba(15, 23, 42, .04), 0 2px 4px rgba(15, 23, 42, .02); }
        .toolbar-btn { transition: all .15s ease; }
        .toolbar-btn:hover { transform: translateY(-1px); }
        .menu-grid { container-type: inline-size; }
        @container (min-width: 1024px) {
            .menu-grid-inner { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }
        @container (min-width: 640px) {
            .menu-grid-inner { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
    </style>
</head>
<body class="min-h-screen text-slate-800">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('master.partials.topbar')

    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-indigo-600">Master Console</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Hak Akses Menu</h2>
                <p class="mt-1 text-sm text-slate-500">Atur menu yang dapat diakses oleh setiap user. Klik baris untuk membuka detail.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button id="add-user" type="button" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm shadow-indigo-600/20 transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah User
                </button>
                <button id="expand-all" type="button" class="toolbar-btn inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:border-indigo-200 hover:text-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                    Buka semua
                </button>
                <button id="collapse-all" type="button" class="toolbar-btn inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 shadow-sm hover:border-indigo-200 hover:text-indigo-600 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.75M15 9V4.75M9 15v4.25M15 15v4.25M4.75 9H9m6 0h4.25M4.75 15H9m6 0h4.25"/></svg>
                    Tutup semua
                </button>
            </div>
        </header>

        <section class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Daftar User & Hak Akses</h3>
                    <p class="mt-1 text-xs text-slate-500">Klik baris user untuk membuka dan mengubah menu yang diizinkan.</p>
                </div>
            </div>

            <div class="hidden md:grid md:grid-cols-12 items-center gap-3 px-5 py-3 bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                <div class="col-span-1"></div>
                <div class="col-span-4">User</div>
                <div class="col-span-3">Username</div>
                <div class="col-span-1 text-center">Menu</div>
                <div class="col-span-3 text-right">Aksi</div>
            </div>

            <div id="users-body" class="divide-y divide-slate-100">
                @forelse ($users as $u)
                    @php
                        $selected = collect($u->hak_akses ?? [])->map(fn ($v) => (int)$v)->all();
                        $initial = strtoupper(mb_substr($u->nama ?? '?', 0, 1));
                    @endphp
                    <div class="user-row" data-user-id="{{ $u->id }}">
                        <details>
                            <summary class="grid grid-cols-12 items-center gap-3 px-4 md:px-5 py-3.5 transition hover:bg-slate-50">
                                <div class="col-span-1 flex justify-center">
                                    <svg class="chev h-4 w-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </div>
                                <div class="col-span-7 md:col-span-4 flex items-center gap-3 min-w-0">
                                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 font-bold text-white text-xs shadow-sm">{{ $initial }}</div>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-800">{{ $u->nama }}</p>
                                        <p class="truncate text-xs text-slate-500 md:hidden">{{ $u->username }}</p>
                                    </div>
                                </div>
                                <div class="hidden md:block col-span-3 truncate text-sm text-slate-600">{{ $u->username }}</div>
                                <div class="hidden md:flex col-span-1 items-center justify-center">
                                    <span class="inline-flex items-center gap-1 rounded-md bg-indigo-50 px-2 py-0.5 text-xs font-semibold text-indigo-700">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                                        <span class="user-count">{{ count($selected) }}</span>
                                    </span>
                                </div>
                                <div class="col-span-4 md:col-span-3 flex items-center justify-end gap-1">
                                    <button type="button" class="select-all-btn inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-semibold text-indigo-600 hover:bg-indigo-50 transition" title="Pilih semua">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        Semua
                                    </button>
                                    <button type="button" class="clear-all-btn inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition" title="Kosongkan">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Reset
                                    </button>
                                </div>
                            </summary>

                            <div class="px-4 md:px-5 pb-5 pt-2 bg-gradient-to-b from-slate-50/60 to-white border-t border-slate-100">
                                <div class="menu-grid mt-3">
                                    <div class="menu-grid-inner grid grid-cols-1 gap-3">
                                        @foreach ($grouped as $groupName => $bucket)
                                            @if ($bucket['parents']->isNotEmpty())
                                                <div class="group-card rounded-xl border border-slate-200 bg-white p-4">
                                                    <div class="mb-3 flex items-center gap-2 border-b border-slate-100 pb-2">
                                                        <span class="h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                                                        <p class="text-xs font-bold uppercase tracking-wider text-slate-700">{{ $groupName }}</p>
                                                        <span class="ml-auto text-[10px] font-semibold text-slate-400">{{ $bucket['parents']->count() }} menu</span>
                                                    </div>
                                                    <div class="space-y-0.5">
                                                        @foreach ($bucket['parents'] as $parent)
                                                            @php
                                                                $children = $bucket['children']->get($parent->id, collect());
                                                                $hasChildren = $children->isNotEmpty();
                                                            @endphp
                                                            <div>
                                                                <label class="menu-row flex items-center gap-2.5 rounded-md px-2 py-1.5 cursor-pointer">
                                                                    <input type="checkbox" class="cb menu-cb parent-cb h-4 w-4 flex-shrink-0" value="{{ $parent->id }}" data-children='@json($children->pluck("id"))' @checked(in_array($parent->id, $selected))>
                                                                    <span class="text-sm font-medium text-slate-800">{{ $parent->nama_menu }}</span>
                                                                </label>
                                                                @if ($hasChildren)
                                                                    <div class="ml-7 mt-0.5 space-y-0.5 border-l-2 border-slate-200 pl-3">
                                                                        @foreach ($children as $child)
                                                                            <label class="menu-row flex items-center gap-2.5 rounded-md px-2 py-1 cursor-pointer">
                                                                                <input type="checkbox" class="cb menu-cb child-cb h-3.5 w-3.5 flex-shrink-0" value="{{ $child->id }}" data-parent="{{ $parent->id }}" @checked(in_array($child->id, $selected))>
                                                                                <span class="text-xs text-slate-600">{{ $child->nama_menu }}</span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-col-reverse gap-2 border-t border-slate-100 pt-3 sm:flex-row sm:justify-end">
                                    <button type="button" class="clear-all-btn inline-flex min-h-10 items-center justify-center rounded-xl border border-slate-200 bg-white px-4 text-xs font-semibold text-slate-700 hover:border-slate-300 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100 transition">
                                        Reset
                                    </button>
                                    <button type="button" class="save-btn inline-flex min-h-10 items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 text-xs font-semibold text-white shadow-sm shadow-indigo-500/20 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 disabled:opacity-50 transition">
                                        <svg class="h-3.5 w-3.5 save-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        <svg class="h-3.5 w-3.5 spin-icon hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/></svg>
                                        <span class="save-label">Simpan Perubahan</span>
                                    </button>
                                </div>
                            </div>
                        </details>
                    </div>
                @empty
                    <div class="px-5 py-14 text-center">
                        <div class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <p class="text-sm font-semibold text-slate-700">Belum ada user</p>
                        <p class="mt-1 text-xs text-slate-500">Tambahkan user dulu untuk mengatur hak akses.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <p class="mt-6 text-center text-xs text-slate-400">&copy; {{ date('Y') }} {{ env('APP_NAME') }}</p>
    </main>

    <div id="add-user-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="add-user-title">
        <div class="w-full max-w-5xl rounded-2xl bg-white shadow-2xl">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-3 sm:px-6">
                <div>
                    <h3 id="add-user-title" class="text-base font-bold text-slate-900">Tambah User</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Buat akun baru lengkap dengan jabatan dan hak akses menu.</p>
                </div>
                <button type="button" id="close-add-user-modal" aria-label="Close" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form id="add-user-form" class="px-5 py-4 sm:px-6">
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-5">
                    <div class="space-y-2 lg:col-span-2">
                        <div>
                            <label for="add-nama" class="mb-0.5 block text-[11px] font-semibold text-slate-700">Nama <span class="text-rose-500">*</span></label>
                            <input id="add-nama" name="nama" type="text" required class="invoice-input" placeholder="Nama lengkap">
                        </div>
                        <div>
                            <label for="add-username" class="mb-0.5 block text-[11px] font-semibold text-slate-700">Username <span class="text-rose-500">*</span></label>
                            <input id="add-username" name="username" type="text" required class="invoice-input" placeholder="username_baru">
                        </div>
                        <div>
                            <label for="add-jabatan" class="mb-0.5 block text-[11px] font-semibold text-slate-700">Jabatan</label>
                            <select id="add-jabatan" name="jabatan" class="invoice-input">
                                <option value="">— Pilih jabatan —</option>
                                @foreach (($jabatans ?? collect()) as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="add-telepon" class="mb-0.5 block text-[11px] font-semibold text-slate-700">Telepon</label>
                            <input id="add-telepon" name="telepon" type="text" class="invoice-input" placeholder="08xxx">
                        </div>
                        <div>
                            <label for="add-email" class="mb-0.5 block text-[11px] font-semibold text-slate-700">Email</label>
                            <input id="add-email" name="email" type="email" class="invoice-input" placeholder="opsional@mail.com">
                        </div>
                        <div>
                            <label for="add-password" class="mb-0.5 block text-[11px] font-semibold text-slate-700">Password <span class="text-rose-500">*</span></label>
                            <input id="add-password" name="password" type="password" required minlength="6" class="invoice-input" placeholder="Minimal 6 karakter">
                        </div>
                    </div>

                    <div class="lg:col-span-3 lg:border-l lg:border-slate-100 lg:pl-4">
                        <div class="mb-1.5 flex items-center justify-between">
                            <div>
                                <p class="text-[11px] font-semibold text-slate-700">Hak Akses Menu</p>
                                <p class="text-[10px] text-slate-500">Centang menu yang boleh diakses.</p>
                            </div>
                            <div class="flex items-center gap-1">
                                <button type="button" id="add-select-all" class="rounded-md px-2 py-0.5 text-[10px] font-semibold text-indigo-600 hover:bg-indigo-50">Semua</button>
                                <button type="button" id="add-clear-all" class="rounded-md px-2 py-0.5 text-[10px] font-semibold text-rose-600 hover:bg-rose-50">Reset</button>
                            </div>
                        </div>
                        <div class="menu-grid menu-scroll rounded-xl border border-slate-200 p-2.5">
                            <div class="menu-grid-inner grid grid-cols-1 gap-2 sm:grid-cols-2">
                                @foreach ($grouped as $groupName => $bucket)
                                    @if ($bucket['parents']->isNotEmpty())
                                        <div class="group-card rounded-lg border border-slate-200 bg-white p-2">
                                            <div class="mb-1 flex items-center gap-1.5 border-b border-slate-100 pb-1">
                                                <span class="h-1 w-1 rounded-full bg-indigo-500"></span>
                                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-700">{{ $groupName }}</p>
                                            </div>
                                            <div class="space-y-0.5">
                                                @foreach ($bucket['parents'] as $parent)
                                                    @php $children = $bucket['children']->get($parent->id, collect()); @endphp
                                                    <label class="menu-row flex items-center gap-1.5 rounded-md px-1 py-0.5 cursor-pointer">
                                                        <input type="checkbox" class="cb add-menu-cb add-parent-cb h-3.5 w-3.5 flex-shrink-0" value="{{ $parent->id }}" data-children='@json($children->pluck("id"))'>
                                                        <span class="text-[11px] font-semibold text-slate-800">{{ $parent->nama_menu }}</span>
                                                    </label>
                                                    @if ($children->isNotEmpty())
                                                        <div class="ml-5 space-y-0.5 border-l-2 border-slate-200 pl-2">
                                                            @foreach ($children as $child)
                                                                <label class="menu-row flex items-center gap-1.5 rounded-md px-1 py-0.5 cursor-pointer">
                                                                    <input type="checkbox" class="cb add-menu-cb add-child-cb h-3 w-3 flex-shrink-0" value="{{ $child->id }}" data-parent="{{ $parent->id }}">
                                                                    <span class="text-[10px] text-slate-600">{{ $child->nama_menu }}</span>
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div id="add-user-error" class="mt-2 hidden rounded-lg border border-rose-200 bg-rose-50 px-3 py-2 text-[11px] text-rose-700"></div>

                <div class="mt-3 flex flex-col-reverse gap-2 border-t border-slate-100 pt-2.5 sm:flex-row sm:justify-end">
                    <button type="button" id="cancel-add-user-modal" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-slate-200 bg-white px-4 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-4 focus:ring-slate-100">Batal</button>
                    <button type="submit" id="submit-add-user" class="inline-flex min-h-9 items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 text-xs font-semibold text-white shadow-sm shadow-indigo-500/20 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 disabled:opacity-50">
                        <svg class="h-3.5 w-3.5 submit-icon" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <svg class="h-3.5 w-3.5 spin-icon hidden animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"/></svg>
                        <span class="submit-label">Simpan User</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrf = '{{ csrf_token() }}';

        function updateCount(row) {
            const n = row.querySelectorAll('.menu-cb:checked').length;
            const c = row.querySelector('.user-count');
            if (c) c.textContent = n;
        }

        function syncParent(row, parentId) {
            const parent = row.querySelector(`.parent-cb[value="${parentId}"]`);
            if (!parent) return;
            const siblings = row.querySelectorAll(`.child-cb[data-parent="${parentId}"]`);
            parent.checked = siblings.length > 0 && Array.from(siblings).every((c) => c.checked);
        }

        document.querySelectorAll('#users-body .menu-cb').forEach((cb) => {
            cb.addEventListener('change', function () {
                const row = this.closest('.user-row');
                if (this.classList.contains('parent-cb')) {
                    let ids = [];
                    try { ids = JSON.parse(this.dataset.children || '[]'); } catch (_) {}
                    ids.forEach((id) => {
                        const c = row.querySelector(`.child-cb[value="${id}"]`);
                        if (c) c.checked = this.checked;
                    });
                } else if (this.classList.contains('child-cb')) {
                    syncParent(row, this.dataset.parent);
                }
                updateCount(row);
            });
        });

        document.querySelectorAll('#users-body .select-all-btn').forEach((btn) => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const row = this.closest('.user-row');
                const det = row.querySelector('details');
                if (det && !det.open) det.open = true;
                row.querySelectorAll('.menu-cb').forEach((c) => (c.checked = true));
                updateCount(row);
            });
        });

        document.querySelectorAll('#users-body .clear-all-btn').forEach((btn) => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const row = this.closest('.user-row');
                row.querySelectorAll('.menu-cb').forEach((c) => (c.checked = false));
                updateCount(row);
            });
        });

        document.querySelectorAll('#users-body .save-btn').forEach((btn) => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const row = this.closest('.user-row');
                const id = row.dataset.userId;
                const ids = Array.from(row.querySelectorAll('.menu-cb:checked')).map((c) => c.value);

                this.disabled = true;
                this.querySelector('.save-icon').classList.add('hidden');
                this.querySelector('.spin-icon').classList.remove('hidden');
                this.querySelector('.save-label').textContent = 'Menyimpan...';

                const fd = new FormData();
                fd.append('_token', csrf);
                fd.append('_method', 'PUT');
                ids.forEach((v) => fd.append('menu_ids[]', v));

                fetch(`/master/hak-akses/${id}`, { method: 'POST', body: fd })
                    .then((r) => r.json().then((j) => ({ ok: r.ok, j })))
                    .then(({ ok, j }) => {
                        if (ok) Swal.fire({ icon: 'success', title: 'Tersimpan', text: `${j.count} menu disimpan`, timer: 1400, showConfirmButton: false });
                        else Swal.fire({ icon: 'error', title: 'Gagal', text: j.message || 'Coba lagi' });
                    })
                    .catch(() => Swal.fire({ icon: 'error', title: 'Gagal', text: 'Network error' }))
                    .finally(() => {
                        this.disabled = false;
                        this.querySelector('.save-icon').classList.remove('hidden');
                        this.querySelector('.spin-icon').classList.add('hidden');
                        this.querySelector('.save-label').textContent = 'Simpan Perubahan';
                    });
            });
        });

        document.getElementById('expand-all').addEventListener('click', () => {
            document.querySelectorAll('#users-body details').forEach((d) => (d.open = true));
        });
        document.getElementById('collapse-all').addEventListener('click', () => {
            document.querySelectorAll('#users-body details').forEach((d) => (d.open = false));
        });

        const addModal = document.getElementById('add-user-modal');
        const addForm = document.getElementById('add-user-form');
        const addError = document.getElementById('add-user-error');

        function setAddModalState(open) {
            addModal.classList.toggle('hidden', !open);
            addModal.classList.toggle('flex', open);
            document.body.classList.toggle('overflow-hidden', open);
            if (open) {
                addError.classList.add('hidden');
                addError.textContent = '';
                document.getElementById('add-nama').focus();
            }
        }

        $('#add-jabatan').select2({
            theme: 'bootstrap-5',
            width: '100%',
            placeholder: '— Pilih jabatan —',
            allowClear: true,
            dropdownParent: $('#add-user-modal'),
        });

        function syncAddParent(parentId) {
            const parent = addForm.querySelector(`.add-parent-cb[value="${parentId}"]`);
            if (!parent) return;
            const siblings = addForm.querySelectorAll(`.add-child-cb[data-parent="${parentId}"]`);
            parent.checked = siblings.length > 0 && Array.from(siblings).every((c) => c.checked);
        }

        addForm.querySelectorAll('.add-menu-cb').forEach((cb) => {
            cb.addEventListener('change', function () {
                if (this.classList.contains('add-parent-cb')) {
                    let ids = [];
                    try { ids = JSON.parse(this.dataset.children || '[]'); } catch (_) {}
                    ids.forEach((id) => {
                        const c = addForm.querySelector(`.add-child-cb[value="${id}"]`);
                        if (c) c.checked = this.checked;
                    });
                } else if (this.classList.contains('add-child-cb')) {
                    syncAddParent(this.dataset.parent);
                }
            });
        });

        document.getElementById('add-select-all').addEventListener('click', () => {
            addForm.querySelectorAll('.add-menu-cb').forEach((c) => (c.checked = true));
        });
        document.getElementById('add-clear-all').addEventListener('click', () => {
            addForm.querySelectorAll('.add-menu-cb').forEach((c) => (c.checked = false));
        });

        document.getElementById('add-user').addEventListener('click', () => {
            addForm.reset();
            addForm.querySelectorAll('.add-menu-cb').forEach((c) => (c.checked = false));
            setAddModalState(true);
        });
        document.getElementById('close-add-user-modal').addEventListener('click', () => setAddModalState(false));
        document.getElementById('cancel-add-user-modal').addEventListener('click', () => setAddModalState(false));
        addModal.addEventListener('click', (e) => { if (e.target === addModal) setAddModalState(false); });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !addModal.classList.contains('hidden')) setAddModalState(false);
        });

        addForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = document.getElementById('submit-add-user');
            btn.disabled = true;
            btn.querySelector('.submit-icon').classList.add('hidden');
            btn.querySelector('.spin-icon').classList.remove('hidden');
            btn.querySelector('.submit-label').textContent = 'Menyimpan...';
            addError.classList.add('hidden');

            const fd = new FormData(addForm);
            fd.append('_token', csrf);
            const ids = Array.from(addForm.querySelectorAll('.add-menu-cb:checked')).map((c) => c.value);
            ids.forEach((v) => fd.append('menu_ids[]', v));

            fetch('{{ route('master.hak-akses.store') }}', { method: 'POST', body: fd })
                .then((r) => r.json().then((j) => ({ ok: r.ok, j })))
                .then(({ ok, j }) => {
                    if (ok) {
                        Swal.fire({ icon: 'success', title: 'User ditambah', text: `${j.user.nama} • ${j.count} menu`, timer: 1600, showConfirmButton: false })
                            .then(() => window.location.reload());
                    } else {
                        const msg = j.errors ? Object.values(j.errors).flat().join(' • ') : (j.message || 'Coba lagi');
                        addError.textContent = msg;
                        addError.classList.remove('hidden');
                    }
                })
                .catch(() => {
                    addError.textContent = 'Network error';
                    addError.classList.remove('hidden');
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.querySelector('.submit-icon').classList.remove('hidden');
                    btn.querySelector('.spin-icon').classList.add('hidden');
                    btn.querySelector('.submit-label').textContent = 'Simpan User';
                });
        });
    </script>

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
