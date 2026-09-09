@extends('layouts.admin')

@section('title', 'Partners')

@section('content')
<div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
    <div><p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Trust &amp; Community</p><h1 class="mt-1 text-3xl font-black">Sponsors &amp; Partners</h1><p class="mt-2 text-sm text-slate-500">Manage organizations that support the Hope &amp; Care mission.</p></div>
</div>

<div class="mt-6 grid gap-6 lg:grid-cols-3">
    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:col-span-1">
        <h2 class="text-lg font-black">Add partner</h2>
        <form method="POST" action="{{ route('admin.partners.store') }}" class="mt-5 space-y-4">
            @csrf
            <div><label class="text-sm font-semibold">Organization name</label><input name="name" required class="mt-1 w-full rounded-xl border p-3" placeholder="Partner organization"></div>
            <div><label class="text-sm font-semibold">Logo URL</label><input name="logo" class="mt-1 w-full rounded-xl border p-3" placeholder="https://..."></div>
            <div><label class="text-sm font-semibold">Website</label><input type="url" name="website" class="mt-1 w-full rounded-xl border p-3" placeholder="https://..."></div>
            <div><label class="text-sm font-semibold">Description</label><textarea name="description" rows="3" class="mt-1 w-full rounded-xl border p-3" placeholder="Optional short description"></textarea></div>
            <div class="flex gap-3"><input type="number" name="sort_order" value="0" min="0" class="w-28 rounded-xl border p-3"><label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="published" value="1" checked> Visible on website</label></div>
            <button class="w-full rounded-xl bg-emerald-700 px-4 py-3 font-bold text-white hover:bg-emerald-800">Add partner</button>
        </form>
    </section>

    <section class="space-y-4 lg:col-span-2">
        @forelse($partners as $partner)
            <form method="POST" action="{{ route('admin.partners.update', $partner) }}" class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                @csrf @method('PUT')
                <div class="grid gap-4 sm:grid-cols-2">
                    <div><label class="text-xs font-bold text-slate-500">Name</label><input name="name" value="{{ $partner->name }}" required class="mt-1 w-full rounded-xl border p-3"></div>
                    <div><label class="text-xs font-bold text-slate-500">Logo URL</label><input name="logo" value="{{ $partner->logo }}" class="mt-1 w-full rounded-xl border p-3"></div>
                    <div><label class="text-xs font-bold text-slate-500">Website</label><input type="url" name="website" value="{{ $partner->website }}" class="mt-1 w-full rounded-xl border p-3"></div>
                    <div><label class="text-xs font-bold text-slate-500">Order</label><input type="number" name="sort_order" min="0" value="{{ $partner->sort_order }}" class="mt-1 w-full rounded-xl border p-3"></div>
                    <div class="sm:col-span-2"><label class="text-xs font-bold text-slate-500">Description</label><textarea name="description" rows="2" class="mt-1 w-full rounded-xl border p-3">{{ $partner->description }}</textarea></div>
                </div>
                <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                    <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="published" value="1" {{ $partner->published ? 'checked' : '' }}> Published</label>
                    <div class="flex gap-2"><button class="rounded-xl bg-emerald-700 px-4 py-2 text-sm font-bold text-white">Save changes</button></div>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="-mt-3 text-right">@csrf @method('DELETE')<button onclick="return confirm('Remove this partner?')" class="text-xs font-bold text-rose-600">Remove partner</button></form>
        @empty
            <div class="rounded-2xl bg-white p-10 text-center text-sm text-slate-500 ring-1 ring-slate-200">No partners have been added yet.</div>
        @endforelse
        <div>{{ $partners->links() }}</div>
    </section>
</div>
@endsection
