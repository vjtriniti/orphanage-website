@extends('auth.layout')
@section('title','Administrator Sign in')
@section('content')
<div class="mb-8">
    <div class="text-sm font-black tracking-[.2em] text-emerald-700">HOPE &amp; CARE · ADMIN</div>
    <h2 class="mt-3 text-3xl font-black text-slate-900">Administrator sign in</h2>
    <p class="mt-2 text-slate-500">Sign in with an authorized staff account to access the management dashboard.</p>
</div>
<form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
    @csrf
    <div>
        <label class="text-sm font-semibold text-slate-700">Administrator email</label>
        <input name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
    </div>
    <div>
        <div class="flex justify-between">
            <label class="text-sm font-semibold text-slate-700">Password</label>
            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-emerald-700">Forgot?</a>
        </div>
        <input name="password" type="password" required autocomplete="current-password" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:border-emerald-500">
    </div>
    <label class="flex items-center gap-2 text-sm text-slate-600">
        <input type="checkbox" name="remember"> Remember me
    </label>
    <button class="w-full rounded-xl bg-emerald-800 px-4 py-3 font-bold text-white shadow-lg shadow-emerald-800/20 hover:bg-emerald-900">Sign in to Admin</button>
</form>
<div class="mt-6 flex flex-col gap-3 text-center text-sm text-slate-500">
    <a class="font-bold text-emerald-700" href="{{ route('login') }}">Donor / User login</a>
    <a class="font-bold text-slate-600 hover:text-emerald-700" href="{{ route('home') }}">← Back to Hope &amp; Care</a>
</div>
@endsection
