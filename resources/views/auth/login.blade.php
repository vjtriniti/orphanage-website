@extends('auth.layout')
@section('title','Sign in')
@section('content')
<div class="mb-8"><div class="text-sm font-bold tracking-[.2em] text-emerald-700">HOPE &amp; CARE</div><h2 class="mt-3 text-3xl font-black">Welcome back</h2><p class="mt-2 text-slate-500">Sign in to continue to your donor or volunteer account.</p></div>
<form method="POST" action="{{ route('login.store') }}" class="space-y-5">@csrf
<div><label class="text-sm font-semibold">Email</label><input name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500"></div>
<div><div class="flex justify-between"><label class="text-sm font-semibold">Password</label><a href="{{ route('password.request') }}" class="text-sm font-semibold text-emerald-700">Forgot?</a></div><input name="password" type="password" required autocomplete="current-password" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500"></div>
<label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" name="remember"> Remember me</label>
<button class="w-full rounded-xl bg-emerald-700 px-4 py-3 font-bold text-white hover:bg-emerald-800">Sign in</button>
</form>
<div class="mt-6 space-y-3 text-center text-sm text-slate-500"><p>Don't have an account? <a class="font-bold text-emerald-700" href="{{ route('register') }}">Create one</a></p><p><a class="font-bold text-slate-600 hover:text-emerald-700" href="{{ route('admin.login') }}">Administrator / Staff login →</a></p><p><a class="font-semibold text-slate-500 hover:text-emerald-700" href="{{ route('home') }}">← Back to Hope &amp; Care</a></p></div>
@endsection
