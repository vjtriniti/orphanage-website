@extends('layouts.admin')

@section('title', 'Testimonials')

@section('content')
<div class="flex flex-wrap items-end justify-between gap-4">
    <div><p class="text-xs font-bold uppercase tracking-widest text-emerald-600">Content</p><h1 class="mt-1 text-3xl font-black text-emerald-950">Testimonials</h1><p class="mt-2 text-sm text-slate-500">Manage public community testimonials shown on the homepage.</p></div>
</div>

<div class="mt-8 grid gap-6 lg:grid-cols-[360px,1fr]">
    <form method="POST" action="{{ route('admin.testimonials.store') }}" class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        @csrf
        <h2 class="text-lg font-black text-emerald-950">Add testimonial</h2>
        <div class="mt-5 space-y-4">
            <input name="name" required maxlength="120" placeholder="Name" class="w-full rounded-xl border px-4 py-3">
            <input name="role" maxlength="120" placeholder="Role / relationship" class="w-full rounded-xl border px-4 py-3">
            <textarea name="quote" required maxlength="2000" rows="5" placeholder="Testimonial" class="w-full rounded-xl border px-4 py-3"></textarea>
            <input name="image" maxlength="255" placeholder="Optional image path" class="w-full rounded-xl border px-4 py-3">
            <input type="number" name="sort_order" min="0" value="0" placeholder="Sort order" class="w-full rounded-xl border px-4 py-3">
            <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="published" value="1" checked> Publish on homepage</label>
            <button class="w-full rounded-xl bg-emerald-800 px-4 py-3 font-bold text-white hover:bg-emerald-700">Add testimonial</button>
        </div>
    </form>

    <div class="space-y-4">
        @forelse($testimonials as $testimonial)
            <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}">
                    @csrf @method('PUT')
                    <div class="grid gap-4 sm:grid-cols-2">
                        <input name="name" value="{{ $testimonial->name }}" required class="rounded-xl border px-4 py-3 font-bold">
                        <input name="role" value="{{ $testimonial->role }}" class="rounded-xl border px-4 py-3">
                        <textarea name="quote" required rows="4" class="rounded-xl border px-4 py-3 sm:col-span-2">{{ $testimonial->quote }}</textarea>
                        <input name="image" value="{{ $testimonial->image }}" class="rounded-xl border px-4 py-3">
                        <input type="number" name="sort_order" min="0" value="{{ $testimonial->sort_order }}" class="rounded-xl border px-4 py-3">
                    </div>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                        <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="published" value="1" @checked($testimonial->published)> Published</label>
                        <div class="flex gap-2"><button class="rounded-xl bg-emerald-800 px-4 py-2 text-sm font-bold text-white">Save</button></div>
                    </div>
                </form>
                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="mt-3" onsubmit="return confirm('Delete this testimonial?')">
                    @csrf @method('DELETE')
                    <button class="text-sm font-bold text-rose-600 hover:text-rose-700">Delete testimonial</button>
                </form>
            </div>
        @empty
            <div class="rounded-2xl bg-white p-10 text-center text-slate-500 ring-1 ring-slate-200">No testimonials yet. Add the first one using the form.</div>
        @endforelse
        <div>{{ $testimonials->links() }}</div>
    </div>
</div>
@endsection
