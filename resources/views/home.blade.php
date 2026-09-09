@extends('layouts.app')

@section('content')

<section class="relative overflow-hidden bg-emerald-950 text-white">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(245,158,11,.18),transparent_35%),radial-gradient(circle_at_10%_90%,rgba(16,185,129,.18),transparent_35%)]"></div>
    <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-6 py-20 lg:grid-cols-2 lg:py-28">
        <div>
            <span class="inline-flex rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-2 text-sm font-bold text-amber-300">✦ Hope starts with you</span>
            <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight sm:text-5xl lg:text-6xl">Every child deserves <span class="text-amber-400">a brighter future.</span></h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-emerald-100">Hope &amp; Care creates safe, caring and empowering opportunities through education, healthcare, nutrition and community support.</p>
            <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                <a href="{{ route('donate') }}" class="rounded-full bg-amber-400 px-7 py-3.5 text-center font-black text-emerald-950 shadow-xl transition hover:bg-amber-300">Donate Now →</a>
                <a href="{{ route('volunteer.apply') }}" class="rounded-full border border-white/20 bg-white/10 px-7 py-3.5 text-center font-bold text-white backdrop-blur transition hover:bg-white/20">Become a Volunteer</a>
            </div>
            <div class="mt-10 grid grid-cols-2 gap-6 border-t border-white/10 pt-8 sm:grid-cols-4">
                <div><p class="text-2xl font-black text-white">{{ number_format($stats['children']) }}</p><p class="mt-1 text-xs text-emerald-200">Children supported</p></div>
                <div><p class="text-2xl font-black text-white">{{ number_format($stats['volunteers']) }}</p><p class="mt-1 text-xs text-emerald-200">Volunteers</p></div>
                <div><p class="text-2xl font-black text-white">{{ number_format($stats['donors']) }}</p><p class="mt-1 text-xs text-emerald-200">Donors</p></div>
                <div><p class="text-2xl font-black text-white">₦{{ number_format($stats['donations'], 0) }}</p><p class="mt-1 text-xs text-emerald-200">Raised</p></div>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -inset-5 rounded-[2rem] bg-amber-400/10 blur-2xl"></div>
            <div class="relative min-h-[420px] overflow-hidden rounded-[2rem] border border-white/10 bg-gradient-to-br from-emerald-700 via-emerald-600 to-amber-500 p-8 shadow-2xl">
                <div class="absolute right-8 top-8 rounded-2xl bg-white/15 px-4 py-3 text-right backdrop-blur"><p class="text-xs font-bold text-emerald-100">ACTIVE CAMPAIGNS</p><p class="text-2xl font-black">{{ $campaigns->count() }}</p></div>
                <div class="absolute bottom-8 left-8 max-w-md"><span class="rounded-full bg-white/20 px-3 py-1 text-xs font-bold">OUR MISSION</span><h2 class="mt-4 text-3xl font-black">Creating safe spaces where children can learn, grow and dream.</h2></div>
            </div>
        </div>
    </div>
</section>

<section class="border-b border-slate-200 bg-white">
    <div class="mx-auto grid max-w-7xl gap-6 px-6 py-7 sm:grid-cols-3">
        <div class="flex items-center gap-4"><span class="grid h-12 w-12 place-items-center rounded-xl bg-emerald-100 text-2xl">❤️</span><div><p class="font-black">Child-centered care</p><p class="text-sm text-slate-500">Every decision starts with wellbeing.</p></div></div>
        <div class="flex items-center gap-4"><span class="grid h-12 w-12 place-items-center rounded-xl bg-amber-100 text-2xl">🎓</span><div><p class="font-black">Education first</p><p class="text-sm text-slate-500">Helping young people build their future.</p></div></div>
        <div class="flex items-center gap-4"><span class="grid h-12 w-12 place-items-center rounded-xl bg-emerald-100 text-2xl">🤝</span><div><p class="font-black">Community powered</p><p class="text-sm text-slate-500">Real change happens together.</p></div></div>
    </div>
</section>

@if($campaigns->isNotEmpty())
<section class="bg-amber-50 py-20">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-4"><div><p class="font-bold text-emerald-700">ACTIVE CAMPAIGNS</p><h2 class="mt-2 text-3xl font-black text-emerald-950 sm:text-4xl">Help fund the next opportunity.</h2></div><a href="{{ route('donate') }}" class="font-bold text-emerald-800">Give now →</a></div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($campaigns as $campaign)
                @php $target=max((float)$campaign->target_amount,1); $raised=(float)$campaign->current_amount; $percent=min(100,round(($raised/$target)*100)); @endphp
                <article class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200 transition hover:-translate-y-1 hover:shadow-xl">
                    @if($campaign->banner)<img src="{{ asset('storage/'.$campaign->banner) }}" alt="{{ $campaign->title }}" class="mb-5 h-40 w-full rounded-2xl object-cover">@else<div class="mb-5 h-40 rounded-2xl bg-gradient-to-br from-emerald-800 to-amber-400"></div>@endif
                    <h3 class="text-xl font-black text-emerald-950">{{ $campaign->title }}</h3><p class="mt-2 text-sm leading-6 text-slate-600">{{ Str::limit($campaign->description,120) }}</p>
                    <div class="mt-5 flex justify-between text-xs font-bold"><span>{{ $campaign->currency ?? 'NGN' }} {{ number_format($raised,0) }} raised</span><span>{{ $percent }}%</span></div>
                    <div class="mt-2 h-3 overflow-hidden rounded-full bg-slate-200"><div class="h-full rounded-full bg-emerald-700" style="width:{{ $percent }}%"></div></div>
                    <p class="mt-2 text-xs text-slate-500">Goal: {{ number_format($target,0) }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-white py-20">
    <div class="mx-auto max-w-7xl px-6">
        <div class="flex flex-wrap items-end justify-between gap-4"><div><p class="font-bold text-emerald-700">UPCOMING EVENTS</p><h2 class="mt-2 text-3xl font-black text-emerald-950 sm:text-4xl">Join the community.</h2></div></div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @forelse($events as $event)
                <article class="rounded-3xl bg-slate-50 p-6 ring-1 ring-slate-200">
                    @if($event->image)<img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" class="mb-5 h-40 w-full rounded-2xl object-cover">@endif
                    <div class="flex gap-4"><div class="rounded-xl bg-emerald-100 px-4 py-3 text-center text-emerald-800"><b class="block text-xl">{{ $event->starts_at->format('d') }}</b><small>{{ $event->starts_at->format('M') }}</small></div><div><h3 class="font-black text-emerald-950">{{ $event->title }}</h3><p class="mt-1 text-sm text-slate-500">{{ $event->location ?: 'Hope & Care' }}</p><p class="mt-1 text-sm text-slate-500">{{ $event->starts_at->format('g:i A') }}</p></div></div>
                </article>
            @empty
                <p class="text-slate-500 md:col-span-3">New events will appear here soon.</p>
            @endforelse
        </div>
    </div>
</section>

@if($children->isNotEmpty())
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-7xl px-6"><div><p class="font-bold text-emerald-700">STORIES OF HOPE</p><h2 class="mt-2 text-3xl font-black text-emerald-950 sm:text-4xl">Support growth without exposing private details.</h2><p class="mt-4 max-w-2xl text-slate-600">We share only appropriate, non-identifying information about children and protect sensitive personal details.</p></div>
        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach($children as $child)
                <article class="rounded-3xl bg-white p-7 shadow-sm ring-1 ring-slate-200"><span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">{{ $child->education_status ?: 'Education journey' }}</span><h3 class="mt-5 text-xl font-black text-emerald-950">Child {{ $child->public_code }}</h3><p class="mt-3 text-sm leading-6 text-slate-600">{{ Str::limit($child->success_story ?: 'A young person building skills, confidence and hope for the future.',180) }}</p>@if($child->interests)<p class="mt-4 text-xs font-semibold text-slate-500">Interests: {{ $child->interests }}</p>@endif</article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-white py-20">
    <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:grid-cols-2">
        <div><p class="font-bold text-emerald-700">LATEST NEWS</p><h2 class="mt-2 text-3xl font-black text-emerald-950 sm:text-4xl">Stories from Hope &amp; Care.</h2><div class="mt-8 space-y-4">
            @forelse($posts as $post)<article class="rounded-2xl border border-slate-200 p-6"><p class="text-xs font-bold uppercase tracking-widest text-amber-600">{{ optional($post->created_at)->format('d M Y') }}</p><h3 class="mt-2 text-xl font-black text-emerald-950">{{ $post->title }}</h3><p class="mt-2 text-sm leading-6 text-slate-600">{{ Str::limit($post->excerpt ?: $post->content,150) }}</p></article>@empty<p class="text-slate-500">Our latest stories will appear here soon.</p>@endforelse
        </div></div>
        <div><p class="font-bold text-emerald-700">GALLERY</p><h2 class="mt-2 text-3xl font-black text-emerald-950 sm:text-4xl">Moments that matter.</h2><div class="mt-8 grid grid-cols-2 gap-4">
            @forelse($galleries->first()?->images ?? [] as $image)<img src="{{ asset('storage/'.$image->path) }}" alt="{{ $image->caption ?: 'Hope & Care gallery' }}" class="h-44 w-full rounded-2xl object-cover">@empty<div class="col-span-2 rounded-3xl bg-gradient-to-br from-emerald-800 to-amber-400 p-10 text-center text-white"><p class="text-4xl">📸</p><p class="mt-3 font-bold">Gallery moments will appear here.</p></div>@endforelse
        </div></div>
    </div>
</section>

@if($testimonials->isNotEmpty())
<section class="bg-emerald-950 py-20 text-white"><div class="mx-auto max-w-7xl px-6"><p class="font-bold uppercase tracking-widest text-amber-400">TESTIMONIALS</p><h2 class="mt-2 text-3xl font-black sm:text-4xl">What our community says.</h2><div class="mt-10 grid gap-6 md:grid-cols-3">@foreach($testimonials as $testimonial)<article class="rounded-3xl bg-white/10 p-7 backdrop-blur"><p class="text-lg leading-8 text-emerald-50">“{{ $testimonial->quote }}”</p><div class="mt-6"><p class="font-black text-white">{{ $testimonial->name }}</p><p class="text-sm text-amber-300">{{ $testimonial->role }}</p></div></article>@endforeach</div></div></section>
@endif

<section class="px-6 pb-20 pt-10"><div class="mx-auto max-w-7xl overflow-hidden rounded-[2rem] bg-gradient-to-r from-emerald-800 to-emerald-950 px-7 py-14 text-center shadow-2xl sm:px-12"><span class="text-sm font-black uppercase tracking-[0.2em] text-amber-400">Join the movement</span><h2 class="mx-auto mt-4 max-w-3xl text-3xl font-black text-white sm:text-4xl">Together, we can give children more reasons to believe in tomorrow.</h2><p class="mx-auto mt-5 max-w-2xl leading-7 text-emerald-100">Donate, volunteer or share our mission with your community.</p><div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row"><a href="{{ route('donate') }}" class="rounded-full bg-amber-400 px-7 py-3.5 font-black text-emerald-950 hover:bg-amber-300">Donate Now</a><a href="{{ route('volunteer.apply') }}" class="rounded-full border border-white/20 bg-white/10 px-7 py-3.5 font-bold text-white hover:bg-white/20">Get Involved</a></div></div></section>

@endsection
