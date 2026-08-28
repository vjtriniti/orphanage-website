<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Hope Haven' }}</title>
    <meta name="description" content="Hope Haven — creating brighter futures for children through care, education and opportunity.">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-emerald-700">Hope<span class="text-amber-500">Haven</span></a>
        <div class="hidden items-center gap-7 md:flex">
            <a href="{{ route('home') }}" class="text-sm font-semibold hover:text-emerald-700">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-semibold hover:text-emerald-700">About</a>
            <a href="{{ route('programs') }}" class="text-sm font-semibold hover:text-emerald-700">Programs</a>
            <a href="{{ route('contact') }}" class="text-sm font-semibold hover:text-emerald-700">Contact</a>
            <a href="{{ route('donate') }}" class="rounded-full bg-emerald-700 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-emerald-700/20 hover:bg-emerald-800">Donate</a>
        </div>
    </nav>
</header>

<main>@yield('content')</main>

<footer class="mt-20 bg-slate-950 text-slate-300">
    <div class="mx-auto grid max-w-7xl gap-10 px-6 py-14 md:grid-cols-3">
        <div><h3 class="text-xl font-bold text-white">Hope Haven</h3><p class="mt-3 text-sm leading-6">Building safe, caring and empowering futures for children.</p></div>
        <div><h4 class="font-bold text-white">Quick Links</h4><div class="mt-3 space-y-2 text-sm"><a class="block hover:text-white" href="{{ route('about') }}">About Us</a><a class="block hover:text-white" href="{{ route('programs') }}">Our Programs</a><a class="block hover:text-white" href="{{ route('contact') }}">Contact</a></div></div>
        <div><h4 class="font-bold text-white">Get Involved</h4><p class="mt-3 text-sm leading-6">Your support can help provide education, nutrition, healthcare and opportunity.</p><a href="{{ route('donate') }}" class="mt-4 inline-block font-bold text-amber-400">Make a difference →</a></div>
    </div>
    <div class="border-t border-white/10 px-6 py-5 text-center text-xs">© {{ date('Y') }} Hope Haven. All rights reserved.</div>
</footer>
</body>
</html>
