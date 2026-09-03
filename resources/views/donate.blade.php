@extends('layouts.app')
@section('content')
<section class="mx-auto max-w-5xl px-6 py-16">
    <div class="rounded-[2rem] bg-emerald-950 p-8 text-white md:p-12">
        <span class="font-bold uppercase tracking-widest text-amber-400">MAKE A DIFFERENCE</span>
        <h1 class="mt-4 text-4xl font-black md:text-5xl">Your support can change a child's tomorrow.</h1>
        <p class="mt-5 max-w-2xl leading-7 text-emerald-100">Make a secure contribution through Paystack. Your donation is recorded as pending until the payment provider confirms it.</p>

        @if(session('success'))<div class="mt-6 rounded-xl bg-emerald-700 p-4 font-semibold">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="mt-6 rounded-xl bg-rose-700 p-4 font-semibold">{{ session('error') }}</div>@endif
        @if($errors->any())<div class="mt-6 rounded-xl bg-rose-700 p-4">{{ $errors->first() }}</div>@endif

        <form method="POST" action="{{ route('payments.initialize') }}" class="mt-8 rounded-3xl bg-white p-6 text-slate-900 shadow-xl md:p-8">
            @csrf
            <div class="grid gap-5 md:grid-cols-2">
                <div><label class="text-sm font-bold">Full name</label><input name="donor_name" value="{{ old('donor_name', auth()->user()?->name) }}" required class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3"></div>
                <div><label class="text-sm font-bold">Email</label><input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}" required class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3"></div>
                <div><label class="text-sm font-bold">Amount (NGN)</label><input type="number" min="100" step="0.01" name="amount" value="{{ old('amount') }}" required class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3"></div>
                <div><label class="text-sm font-bold">Currency</label><select name="currency" class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3"><option value="NGN">NGN — Nigerian Naira</option></select></div>
                <div class="md:col-span-2"><label class="text-sm font-bold">Message (optional)</label><textarea name="message" rows="3" class="mt-2 w-full rounded-xl border-slate-200 px-4 py-3">{{ old('message') }}</textarea></div>
            </div>
            <button class="mt-6 w-full rounded-xl bg-emerald-700 px-5 py-4 font-black text-white hover:bg-emerald-800">Continue to secure payment</button>
        </form>
    </div>
</section>
@endsection
