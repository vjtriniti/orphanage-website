<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hope & Care Orphanage' }}</title>
    <meta name="description" content="Hope & Care Orphanage — creating brighter futures through care, education and opportunity.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak]{display:none!important}
        html{scroll-behavior:smooth}
        body{font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        input,textarea,select{border-color:#22c55e!important}
        input:focus,textarea:focus,select:focus{border-color:#16a34a!important;outline:none!important;box-shadow:0 0 0 3px rgba(34,197,94,.15)!important}
        .hc-shadow{box-shadow:0 12px 35px rgba(15,23,42,.08)}
        .hc-section{max-width:1200px;margin:0 auto;padding-left:52px;padding-right:52px}
        @media(max-width:768px){.hc-section{padding-left:22px;padding-right:22px}}
    </style>
</head>
<body class="bg-white text-slate-900 antialiased">
@if(!request()->routeIs('dashboard'))
<header x-data="{open:false}" class="sticky top-0 z-50 border-b border-slate-100 bg-white/95 backdrop-blur">
    <nav class="hc-section">
        <div class="flex h-[68px] items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" @click="open=false" aria-label="Hope & Care home">
                <svg class="h-11 w-11" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                    <path d="M24 43C18 36 7 30 7 18C7 11.4 12.4 7 18.2 7c3 0 5.4 1.2 7 3.6C26.8 8.2 29.2 7 32.2 7 38 7 43 11.4 43 18c0 12-11 18-19 25Z" stroke="#315f3f" stroke-width="2.5"/>
                    <path d="M13 23 24 15l11 8v10H13V23Z" stroke="#315f3f" stroke-width="2"/>
                    <path d="M24 15v18M18 27c-2-4-7-3-7 1 0 3 3 5 7 6M30 27c2-4 7-3 7 1 0 3-3 5-7 6" stroke="#f0ad18" stroke-width="2" stroke-linecap="round"/>
                </svg>
                <span class="leading-none"><span class="block text-[17px] font-extrabold tracking-tight text-emerald-950">Hope &amp; Care</span><span class="mt-1 block text-[9px] font-bold tracking-[0.34em] text-amber-500">ORPHANAGE</span></span>
            </a>
            <div class="hidden items-center gap-7 lg:flex">
                <a href="{{ route('home') }}" class="border-b-2 border-emerald-700 pb-1 text-[13px] font-bold text-emerald-800">Home</a>
                <a href="{{ route('about') }}" class="text-[13px] font-semibold text-slate-700 hover:text-emerald-700">About</a>
                <a href="{{ route('programs') }}" class="text-[13px] font-semibold text-slate-700 hover:text-emerald-700">Programs</a>
                <a href="#campaigns" class="text-[13px] font-semibold text-slate-700 hover:text-emerald-700">Campaigns</a>
                <a href="#events" class="text-[13px] font-semibold text-slate-700 hover:text-emerald-700">Events</a>
                <a href="#gallery" class="text-[13px] font-semibold text-slate-700 hover:text-emerald-700">Gallery</a>
                <a href="{{ route('contact') }}" class="text-[13px] font-semibold text-slate-700 hover:text-emerald-700">Contact</a>
            </div>
            <div class="hidden items-center gap-3 md:flex">
                <button type="button" class="grid h-10 w-10 place-items-center rounded-full text-emerald-900" aria-label="Search">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="6.5" stroke-width="1.8"/><path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/></svg>
                </button>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-[13px] font-bold text-slate-800 hover:border-emerald-700 hover:text-emerald-800">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg border border-slate-300 px-5 py-2.5 text-[13px] font-bold text-slate-800 hover:border-emerald-700 hover:text-emerald-800">Login</a>
                @endauth
                <a href="{{ route('donate') }}" class="rounded-lg bg-emerald-900 px-5 py-2.5 text-[13px] font-bold text-white shadow-lg shadow-emerald-900/20 hover:bg-emerald-800">♡&nbsp; Donate Now</a>
            </div>
            <button type="button" @click="open=!open" class="grid h-10 w-10 place-items-center rounded-lg border border-slate-200 text-emerald-900 md:hidden" aria-label="Toggle navigation">
                <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-width="2" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <div x-show="open" x-cloak x-transition class="border-t border-slate-100 py-4 md:hidden">
            <div class="grid gap-1 pb-2">
                <a @click="open=false" href="{{ route('home') }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Home</a>
                <a @click="open=false" href="{{ route('about') }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">About</a>
                <a @click="open=false" href="{{ route('programs') }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Programs</a>
                <a @click="open=false" href="#campaigns" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Campaigns</a>
                <a @click="open=false" href="#events" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Events</a>
                <a @click="open=false" href="#gallery" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Gallery</a>
                <a @click="open=false" href="{{ route('contact') }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Contact</a>
                @auth<a href="{{ route('dashboard') }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Dashboard</a>@else<a href="{{ route('login') }}" class="rounded-lg px-4 py-3 font-semibold hover:bg-emerald-50">Login</a>@endauth
                <a href="{{ route('donate') }}" class="mt-2 rounded-lg bg-emerald-900 px-4 py-3 text-center font-bold text-white">Donate Now</a>
            </div>
        </div>
    </nav>
</header>
@endif
<main>@yield('content')</main>
@if(!request()->routeIs('dashboard'))
<footer class="bg-[#003d2a] text-white">
    <div class="hc-section grid gap-10 py-14 md:grid-cols-[1.25fr_.8fr_.9fr_1.2fr]">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <svg class="h-11 w-11" viewBox="0 0 48 48" fill="none"><path d="M24 43C18 36 7 30 7 18C7 11.4 12.4 7 18.2 7c3 0 5.4 1.2 7 3.6C26.8 8.2 29.2 7 32.2 7 38 7 43 11.4 43 18c0 12-11 18-19 25Z" stroke="#f0ad18" stroke-width="2.5"/><path d="M13 23 24 15l11 8v10H13V23Z" stroke="#f0ad18" stroke-width="2"/></svg>
                <span><span class="block text-lg font-extrabold">Hope &amp; Care</span><span class="text-[9px] font-bold tracking-[0.32em] text-amber-400">ORPHANAGE</span></span>
            </a>
            <p class="mt-5 max-w-xs text-sm leading-6 text-emerald-100">Building safe, caring and empowering futures for children and young people.</p>
            <div class="mt-5 flex gap-3 text-sm text-emerald-100"><span>f</span><span>𝕏</span><span>◎</span><span>▶</span><span>in</span></div>
        </div>
        <div><h4 class="font-bold">Quick Links</h4><div class="mt-5 space-y-2 text-sm text-emerald-100"><a class="block hover:text-white" href="{{ route('home') }}">Home</a><a class="block hover:text-white" href="{{ route('about') }}">About Us</a><a class="block hover:text-white" href="{{ route('programs') }}">Programs</a><a class="block hover:text-white" href="#campaigns">Campaigns</a><a class="block hover:text-white" href="#events">Events</a><a class="block hover:text-white" href="#gallery">Gallery</a><a class="block hover:text-white" href="{{ route('contact') }}">Contact</a></div></div>
        <div><h4 class="font-bold">Get Involved</h4><div class="mt-5 space-y-2 text-sm text-emerald-100"><a class="block hover:text-white" href="{{ route('donate') }}">Donate</a><a class="block hover:text-white" href="{{ route('volunteer.apply') }}">Volunteer</a><a class="block hover:text-white" href="{{ route('contact') }}">Partner</a><a class="block hover:text-white" href="{{ route('contact') }}">Become a Sponsor</a><a class="block hover:text-white" href="{{ route('donate') }}">Fundraise</a></div></div>
        <div><h4 class="font-bold">Newsletter</h4><p class="mt-5 text-sm leading-6 text-emerald-100">Stay updated with our latest news, events and impact stories.</p><form action="{{ route('newsletter.store') }}" method="POST" class="mt-4 flex overflow-hidden rounded-full border border-emerald-400/40 bg-emerald-950/30">@csrf<input name="email" type="email" required placeholder="Your email address" class="min-w-0 flex-1 border-0 bg-transparent px-5 py-3 text-sm text-white placeholder:text-emerald-200/70"><button class="grid w-12 shrink-0 place-items-center bg-white text-emerald-900" aria-label="Subscribe">→</button></form></div>
    </div>
    <div class="border-t border-white/10"><div class="hc-section flex flex-col justify-between gap-3 py-5 text-[11px] text-emerald-100 sm:flex-row"><span>© {{ date('Y') }} Hope &amp; Care Orphanage. All rights reserved.</span><span>Privacy Policy&nbsp;&nbsp; | &nbsp;&nbsp;Terms &amp; Conditions</span></div></div>
</footer>
@endif
</body>
</html>
