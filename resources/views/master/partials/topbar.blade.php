@php
    $navItems = [
        ['route' => 'master.dashboard', 'match' => 'master.dashboard*', 'label' => 'Dashboard', 'icon' => 'home'],
        ['route' => 'master.hak-akses', 'match' => 'master.hak-akses*', 'label' => 'Access Rights', 'icon' => 'shield'],
        ['route' => 'master.invoice.index', 'match' => 'master.invoice.*', 'label' => 'Invoices', 'icon' => 'doc'],
    ];
    $admin = Auth::guard('master')->user();
@endphp

<header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-16 items-center justify-between gap-3">
            <div class="flex min-w-0 flex-shrink-0 items-center gap-3">
                <a href="{{ route('master.dashboard') }}" aria-label="Master dashboard" class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-md shadow-indigo-500/20">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </a>
                <div class="min-w-0">
                    <p class="text-[11px] font-semibold uppercase tracking-wider text-slate-400">Master Console</p>
                    <h1 class="truncate text-sm font-bold text-slate-900 sm:text-base">{{ env('APP_NAME') }}</h1>
                </div>
            </div>

            <nav class="hidden flex-1 items-center justify-center gap-1 md:flex">
                @foreach ($navItems as $item)
                    @php $active = request()->routeIs($item['match'] ?? $item['route']); @endphp
                    <a href="{{ route($item['route']) }}" class="inline-flex items-center gap-2 rounded-lg px-3.5 py-2 text-sm font-medium transition {{ $active ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        @if ($item['icon'] === 'home')
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8a1 1 0 001 1h3m4-9l2 2m-2-2v8a1 1 0 01-1 1h-3m0 0v-6a1 1 0 011-1h2a1 1 0 011 1v6"/></svg>
                        @elseif ($item['icon'] === 'shield')
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        @elseif ($item['icon'] === 'cash')
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @else
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex flex-shrink-0 items-center gap-2 sm:gap-3">
                <div class="hidden items-center gap-3 border-r border-slate-200 pr-3 sm:flex">
                    <div class="text-right">
                        <p class="max-w-36 truncate text-sm font-semibold leading-tight text-slate-800">{{ $admin->nama_lengkap }}</p>
                        <p class="max-w-36 truncate text-xs leading-tight text-slate-500">{{ $admin->email }}</p>
                    </div>
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 font-bold text-indigo-700 ring-2 ring-white">
                        {{ strtoupper(mb_substr($admin->nama_lengkap ?? 'M', 0, 1)) }}
                    </div>
                </div>

                <button type="button" id="mobile-menu-button" aria-controls="mobile-menu" aria-expanded="false" class="inline-flex rounded-lg p-2 text-slate-600 hover:bg-slate-100 hover:text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-100 md:hidden">
                    <span class="sr-only">Open navigation</span>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <form id="logout-form" action="{{ route('master.logout') }}" method="POST">
                    @csrf
                    <button type="button" onclick="confirmLogout(event)" class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 hover:text-rose-600 focus:outline-none focus:ring-4 focus:ring-indigo-100 sm:px-4">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="hidden sm:inline">Sign out</span>
                    </button>
                </form>
            </div>
        </div>

        <nav id="mobile-menu" class="hidden border-t border-slate-100 py-3 md:hidden">
            <div class="grid grid-cols-1 gap-1 sm:grid-cols-3">
                @foreach ($navItems as $item)
                    @php $active = request()->routeIs($item['match'] ?? $item['route']); @endphp
                    <a href="{{ route($item['route']) }}" class="inline-flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium {{ $active ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100' }}">
                        @if ($item['icon'] === 'home')
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        @elseif ($item['icon'] === 'shield')
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        @elseif ($item['icon'] === 'cash')
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @else
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        @endif
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>
    </div>
</header>

<script>
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            const isOpen = !mobileMenu.classList.toggle('hidden');
            mobileMenuButton.setAttribute('aria-expanded', String(isOpen));
        });
    }

    function confirmLogout(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Sign out of Master Console?',
            text: 'Your session will end and you will need to sign in again.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, sign out',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-rose-600 text-white font-semibold text-sm hover:bg-rose-700 focus:outline-none focus:ring-4 focus:ring-rose-200 mx-1',
                cancelButton: 'inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-slate-100 text-slate-700 font-semibold text-sm hover:bg-slate-200 focus:outline-none focus:ring-4 focus:ring-slate-200 mx-1',
            },
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
