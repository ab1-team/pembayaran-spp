<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Master Console — {{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/png" href="{{ \App\Models\Profil::logoUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: { 50:'#eef2ff', 100:'#e0e7ff', 500:'#6366f1', 600:'#4f46e5', 700:'#4338ca', 800:'#3730a3', 900:'#312e81' }
                    }
                }
            }
        }
    </script>
    <style>
        html, body { font-family: 'Inter', system-ui, sans-serif; }
        body { -webkit-tap-highlight-color: transparent; }
        .bg-aurora {
            background:
                radial-gradient(at 12% 18%, rgba(99,102,241,.55) 0px, transparent 45%),
                radial-gradient(at 88% 8%, rgba(236,72,153,.45) 0px, transparent 50%),
                radial-gradient(at 78% 92%, rgba(56,189,248,.40) 0px, transparent 50%),
                radial-gradient(at 22% 82%, rgba(168,85,247,.40) 0px, transparent 50%),
                linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4c1d95 100%);
        }
        .blob { position:absolute; border-radius:9999px; filter: blur(60px); opacity:.55; pointer-events:none; }
        @keyframes float-a { 0%,100%{ transform: translate(0,0) scale(1); } 50%{ transform: translate(30px,-40px) scale(1.1); } }
        @keyframes float-b { 0%,100%{ transform: translate(0,0) scale(1); } 50%{ transform: translate(-25px,30px) scale(.92); } }
        .blob-a { animation: float-a 14s ease-in-out infinite; }
        .blob-b { animation: float-b 18s ease-in-out infinite; }
        .glass { background: rgba(255,255,255,.72); backdrop-filter: saturate(180%) blur(24px); -webkit-backdrop-filter: saturate(180%) blur(24px); border:1px solid rgba(255,255,255,.6); }
        .field { position: relative; }
        .field input { transition: border-color .15s ease, box-shadow .15s ease, background-color .15s ease; }
        .field input:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 4px rgba(99,102,241,.15); }
        .field label { position:absolute; left:14px; top:14px; color:#6b7280; pointer-events:none; transition: all .15s ease; background: transparent; padding: 0 4px; }
        .field input:focus + label,
        .field input:not(:placeholder-shown) + label { top:-9px; left:10px; font-size:11px; color:#4f46e5; background:#fff; border-radius:4px; font-weight:600; }
        .ring-focus:focus { outline:none; box-shadow: 0 0 0 4px rgba(99,102,241,.25); }
        .btn-grad { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); transition: transform .12s ease, box-shadow .12s ease, filter .12s ease; }
        .btn-grad:hover { filter: brightness(1.05); transform: translateY(-1px); box-shadow: 0 10px 25px -10px rgba(79,70,229,.6); }
        .btn-grad:active { transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) {
            .blob-a, .blob-b { animation: none; }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

    <div class="lg:grid lg:grid-cols-2 min-h-screen">

        {{-- LEFT: Brand panel --}}
        <aside class="relative overflow-hidden bg-aurora text-white px-6 py-10 sm:px-10 sm:py-14 lg:py-0 lg:flex lg:items-center lg:justify-center">
            <div class="blob blob-a bg-indigo-400 w-72 h-72 top-10 -left-10"></div>
            <div class="blob blob-b bg-pink-400 w-80 h-80 bottom-10 right-0"></div>

            <div class="relative z-10 max-w-md mx-auto lg:mx-0 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur text-xs font-medium tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Restricted Access
                </div>

                <div class="mt-6 flex items-center justify-center lg:justify-start gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/15 backdrop-blur ring-1 ring-white/20 flex items-center justify-center shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-[11px] uppercase tracking-[.18em] text-white/70">Master Console</p>
                        <h1 class="text-lg font-semibold leading-tight">{{ env('APP_NAME') }}</h1>
                    </div>
                </div>

                <h2 class="mt-8 text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight tracking-tight">
                    Run your system<br/>from <span class="bg-clip-text text-transparent bg-gradient-to-r from-amber-200 via-pink-200 to-indigo-200">one console.</span>
                </h2>

                <p class="mt-5 text-sm sm:text-base text-white/80 max-w-sm mx-auto lg:mx-0">
                    A dedicated panel for administrators &amp; master team to oversee master data and internal transactions centrally.
                </p>

                <ul class="mt-8 space-y-3 text-sm text-white/85 max-w-sm mx-auto lg:mx-0">
                    <li class="flex items-center gap-3 justify-center lg:justify-start">
                        <svg class="w-5 h-5 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Centralized master data management
                    </li>
                    <li class="flex items-center gap-3 justify-center lg:justify-start">
                        <svg class="w-5 h-5 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Internal invoices &amp; billing
                    </li>
                    <li class="flex items-center gap-3 justify-center lg:justify-start">
                        <svg class="w-5 h-5 text-emerald-300 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Audit log &amp; access control
                    </li>
                </ul>

                <p class="mt-10 text-xs text-white/60 hidden lg:block">
                    &copy; {{ date('Y') }} {{ env('APP_NAME') }} — Internal use only.
                </p>
            </div>
        </aside>

        {{-- RIGHT: Form --}}
        <main class="px-5 py-10 sm:px-8 sm:py-14 lg:py-0 flex items-center justify-center">
            <div class="w-full max-w-md">

                <div class="lg:hidden mb-8 text-center">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        Master Access
                    </div>
                    <h2 class="mt-3 text-xl font-bold text-slate-900">{{ env('APP_NAME') }}</h2>
                </div>

                <div class="glass rounded-3xl p-7 sm:p-9 shadow-xl shadow-indigo-900/5">
                    <div class="mb-7">
                        <h3 class="text-2xl font-bold text-slate-900">Welcome back</h3>
                        <p class="mt-1.5 text-sm text-slate-500">Sign in to continue to the master console.</p>
                    </div>

                    {{-- Error --}}
                    @if ($errors->any())
                        <div class="mb-5 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                            <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/></svg>
                            <div class="leading-snug">{{ $errors->first() }}</div>
                        </div>
                    @endif

                    <form action="{{ route('master.auth') }}" method="POST" class="space-y-4" autocomplete="on">
                        @csrf

                        <div class="field">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder=" " required autofocus
                                   class="w-full px-3.5 pt-5 pb-2.5 text-[15px] rounded-xl border border-slate-300 bg-white" />
                            <label for="email">Email</label>
                        </div>

                        <div class="field relative">
                            <input id="password" type="password" name="password" placeholder=" " required
                                   class="w-full px-3.5 pt-5 pb-2.5 pr-12 text-[15px] rounded-xl border border-slate-300 bg-white" />
                            <label for="password">Password</label>
                            <button type="button" id="togglePwd" aria-label="Show password"
                                    class="absolute right-2 top-1/2 -translate-y-1/2 p-2 rounded-lg text-slate-400 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                <svg id="eyeOff" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.879l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                <svg id="eyeOn" class="w-5 h-5 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label class="inline-flex items-center gap-2 text-sm text-slate-600 select-none cursor-pointer">
                                <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                Remember me
                            </label>
                            <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn-grad w-full py-3 rounded-xl text-white font-semibold text-[15px] ring-focus mt-2 inline-flex items-center justify-center gap-2">
                            <span>Sign in to Master Console</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </form>

                    <div class="my-7 flex items-center gap-3 text-xs text-slate-400">
                        <span class="flex-1 h-px bg-slate-200"></span>
                        <span class="uppercase tracking-wider">or</span>
                        <span class="flex-1 h-px bg-slate-200"></span>
                    </div>

                    <a href="/" class="block w-full text-center py-3 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-medium text-sm transition">
                        Back to User Login
                    </a>
                </div>

                <p class="mt-6 text-center text-xs text-slate-400 lg:hidden">
                    &copy; {{ date('Y') }} {{ env('APP_NAME') }} — Master access for admins only.
                </p>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function () {
            const pwd = document.getElementById('password');
            const btn = document.getElementById('togglePwd');
            const eyeOn = document.getElementById('eyeOn');
            const eyeOff = document.getElementById('eyeOff');
            btn.addEventListener('click', function () {
                const showing = pwd.type === 'text';
                pwd.type = showing ? 'password' : 'text';
                eyeOn.classList.toggle('hidden', showing);
                eyeOff.classList.toggle('hidden', !showing);
            });
        })();
    </script>

    @if (session('success'))
        <script>
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: @json(session('success')), showConfirmButton: false, timer: 3000, timerProgressBar: true });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({ toast: true, position: 'top-end', icon: 'error', title: @json(session('error')), showConfirmButton: false, timer: 3000, timerProgressBar: true });
        </script>
    @endif

    @if (session('msg'))
        <script>
            Swal.fire({ toast: true, position: 'top-end', icon: @json(session('icon') ?? 'success'), title: @json(session('msg')), showConfirmButton: false, timer: 3000, timerProgressBar: true });
        </script>
    @endif

</body>

</html>
