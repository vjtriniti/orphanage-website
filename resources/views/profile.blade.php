@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-4xl px-6 py-12 space-y-6">
    @if(session('success'))<div class="rounded-xl bg-emerald-50 p-4 font-semibold text-emerald-800">{{ session('success') }}</div>@endif
    <div><p class="text-sm font-bold uppercase tracking-widest text-emerald-700">Account</p><h1 class="mt-2 text-3xl font-black">Profile & security</h1><p class="mt-1 text-slate-500">Manage your account details and two-factor authentication.</p></div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h2 class="text-lg font-black">Account details</h2>
        <div class="mt-4 grid gap-4 md:grid-cols-2"><div><span class="text-xs font-bold uppercase text-slate-400">Name</span><p class="mt-1 font-semibold">{{ auth()->user()->name }}</p></div><div><span class="text-xs font-bold uppercase text-slate-400">Email</span><p class="mt-1 font-semibold">{{ auth()->user()->email }}</p></div></div>
    </div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-wrap items-center justify-between gap-4"><div><h2 class="text-lg font-black">Two-factor authentication</h2><p class="mt-1 text-sm text-slate-500">Add an authenticator-code challenge to protected account and admin actions.</p></div><span class="rounded-full px-3 py-1 text-xs font-black {{ auth()->user()->two_factor_enabled ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">{{ auth()->user()->two_factor_enabled ? 'Enabled' : 'Disabled' }}</span></div>
        @if(auth()->user()->two_factor_enabled)
            <form method="POST" action="{{ route('twofactor.disable') }}" class="mt-6 flex flex-col gap-3 sm:flex-row">@csrf<input name="code" inputmode="numeric" maxlength="6" pattern="[0-9]{6}" placeholder="6-digit code" required class="rounded-xl border-slate-200 px-4 py-3"><button class="rounded-xl bg-rose-600 px-5 py-3 font-bold text-white">Disable 2FA</button></form>
        @else
            <a href="{{ route('twofactor.setup') }}" class="mt-6 inline-flex rounded-xl bg-emerald-700 px-5 py-3 font-bold text-white">Set up 2FA</a>
        @endif
    </div>
</div>
@endsection
