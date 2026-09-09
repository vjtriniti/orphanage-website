<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hope & Care' }}</title>
    <meta name="description" content="Hope & Care — creating brighter futures through care, education and opportunity.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        input, textarea, select { border-color:#22c55e !important; }
        input:focus, textarea:focus, select:focus { border-color:#16a34a !important; outline:none !important; box-shadow:0 0 0 3px rgba(34,197,94,.15) !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
@if(!request()->routeIs('dashboard'))
<header x-data="{ open: false }" class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
    <nav class="mx-auto max-w-7xl px-5">
        <div class="flex h-20 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2" @click="open=false">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-emerald-800 font-black text-amber-300">H</span>
                <span class="text-xl font-black text-emerald-900">Hope <span class="text-amber-500">&amp; Care</span></span>
            </a>
            <div class="hidden items-center gap-6 md:flex">
                <a href="{{ route('home') }}" class="text-sm font-semibold transition hover:text-emerald-700">Home</a>
                <a href="{{ route('about') }}" class="text-sm font-semibold transition hover:text-emerald-700">About</a>
                <a href="{{ route('programs') }}" class="text-sm font-semibold transition hover:text-emerald-700">Programs</a>
                <a href="{{ route('contact') }}" class="text-sm font-semibold transition hover:text-emerald-700">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold transition hover:text-emerald-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold transition hover:text-emerald-700">Login</a>
                @endauth
                <a href="{{ route('donate') }}" class="rounded-full bg-emerald-800 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-800/20 transition hover:bg-emerald-700">Donate Now</a>
            </div>
            <button type="button" @click="open=!open" :aria-expanded="open.toString()" aria-controls="mobile-menu" class="grid h-11 w-11 place-items-center rounded-xl border border-slate-200 text-emerald-900 md:hidden" aria-label="Toggle navigation">
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="mobile-menu" x-show="open" x-cloak x-transition class="border-t border-slate-100 py-4 md:hidden">
            <div class="flex flex-col gap-1">
                <a @click="open=false" href="{{ route('home') }}" class="rounded-xl px-4 py-3 font-semibold hover:bg-emerald-50 hover:text-emerald-800">Home</a>
                <a @click="open=false" href="{{ route('about') }}" class="rounded-xl px-4 py-3 font-semibold hover:bg-emerald-50 hover:text-emerald-800">About</a>
                <a @click="open=false" href="{{ route('programs') }}" class="rounded-xl px-4 py-3 font-semibold hover:bg-emerald-50 hover:text-emerald-800">Programs</a>
                <a @click="open=false" href="{{ route('contact') }}" class="rounded-xl px-4 py-3 font-semibold hover:bg-emerald-50 hover:text-emerald-800">Contact</a>
                @auth
                    <a @click="open=false" href="{{ route('dashboard') }}" class="rounded-xl px-4 py-3 font-semibold hover:bg-emerald-50 hover:text-emerald-800">Dashboard</a>
                @else
                    <a @click="open=false" href="{{ route('login') }}" class="rounded-xl px-4 py-3 font-semibold hover:bg-emerald-50 hover:text-emerald-800">Login</a>
                @endauth
                <a @click="open=false" href="{{ route('donate') }}" class="mt-2 rounded-xl bg-emerald-800 px-4 py-3 text-center font-bold text-white hover:bg-emerald-700">Donate Now</a>
            </div>
        </div>
    </nav>
</header>
@endif
<main>@yield('content')</main>
@if(!request()->routeIs('dashboard'))
<footer class="mt-20 bg-emerald-950 text-slate-300">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 md:grid-cols-3">
        <div><h3 class="text-xl font-black text-white">Hope &amp; Care</h3><p class="mt-3 text-sm leading-6">Building safe, caring and empowering futures for children and young people.</p></div>
        <div><h4 class="font-bold text-white">Explore</h4><div class="mt-3 space-y-2 text-sm"><a class="block hover:text-white" href="{{ route('about') }}">About Us</a><a class="block hover:text-white" href="{{ route('programs') }}">Programs</a><a class="block hover:text-white" href="{{ route('contact') }}">Contact</a></div></div>
        <div><h4 class="font-bold text-white">Get Involved</h4><p class="mt-3 text-sm leading-6">Support education, nutrition, healthcare and opportunity.</p><a href="{{ route('donate') }}" class="mt-4 inline-block font-bold text-amber-400">Make a difference →</a></div>
    </div>
    <div class="border-t border-white/10 px-6 py-5 text-center text-xs">© {{ date('Y') }} Hope &amp; Care. All rights reserved.</div>
</footer>
@endif
</body>
</html>
