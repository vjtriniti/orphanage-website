@extends('layouts.app')

@section('content')
@php
    $heroImages = [
        'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?auto=format&fit=crop&w=1600&q=85',
        'https://images.unsplash.com/photo-1542810634-71277d95dcbb?auto=format&fit=crop&w=1600&q=85',
    ];
    $campaignImages = [
        'https://images.unsplash.com/photo-1509099836639-18ba02c7a1a9?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=900&q=80',
    ];
    $eventImages = [
        'https://images.unsplash.com/photo-1516627145497-ae6968895b74?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1504159506876-f8338247a14a?auto=format&fit=crop&w=900&q=80',
        'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=900&q=80',
    ];
    $campaignList = $campaigns->take(3)->values();
    $eventList = $events->take(3)->values();
    $childrenSupported = max(250, (int)($stats['children'] ?? 0));
    $communitySupporters = max(15000, (int)($stats['donors'] ?? 0) + (int)($stats['volunteers'] ?? 0));
    $activeCampaigns = max(3, $campaigns->count());
@endphp

<section class="relative min-h-[360px] overflow-hidden bg-[#064b35] text-white sm:min-h-[405px] lg:min-h-[430px]">
    <img src="{{ $heroImages[0] }}" alt="Children smiling together" class="absolute inset-0 h-full w-full object-cover object-center">
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(0,60,40,.98)_0%,rgba(0,70,47,.91)_28%,rgba(0,60,40,.35)_59%,rgba(0,45,30,.08)_100%)]"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-[#003d2a]/70 via-transparent to-transparent"></div>
    <div class="hc-section relative grid min-h-[360px] items-center py-12 sm:min-h-[405px] lg:min-h-[430px] lg:grid-cols-[1fr_285px] lg:py-16">
        <div class="max-w-[610px]">
            <p class="text-xs font-extrabold uppercase tracking-wider text-amber-400 sm:text-sm">EVERY CHILD DESERVES A BRIGHTER FUTURE</p>
            <h1 class="mt-4 text-[43px] font-black leading-[.98] tracking-tight sm:text-6xl lg:text-[61px]">Small acts.<br><span class="text-amber-400">Big dreams.</span></h1>
            <p class="mt-5 max-w-[500px] text-sm leading-6 text-white/90 sm:text-base">We provide love, care, education and opportunity to help vulnerable children build a better tomorrow.</p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ route('donate') }}" class="rounded-full bg-amber-400 px-7 py-3 text-sm font-extrabold text-emerald-950 shadow-xl transition hover:bg-amber-300">♡&nbsp; Donate Now</a>
                <a href="{{ route('about') }}" class="rounded-full border border-white/70 bg-white/5 px-7 py-3 text-sm font-bold text-white backdrop-blur hover:bg-white/10">Learn More&nbsp; →</a>
            </div>
        </div>
        <div class="mt-8 hidden overflow-hidden rounded-2xl border border-white/20 bg-emerald-950/45 p-3 shadow-2xl backdrop-blur-md lg:block">
            <div class="divide-y divide-white/15">
                <div class="flex items-center gap-4 px-3 py-3.5"><span class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-xl">♧</span><div><p class="text-[11px] text-white/80">Children Supported</p><p class="text-xl font-black">{{ number_format($childrenSupported) }}+</p></div></div>
                <div class="flex items-center gap-4 px-3 py-3.5"><span class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-xl">♡</span><div><p class="text-[11px] text-white/80">Donors &amp; Volunteers</p><p class="text-xl font-black">{{ number_format($communitySupporters) }}+</p></div></div>
                <div class="flex items-center gap-4 px-3 py-3.5"><span class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-xl">★</span><div><p class="text-[11px] text-white/80">Programs</p><p class="text-xl font-black">12</p></div></div>
                <div class="flex items-center gap-4 px-3 py-3.5"><span class="grid h-11 w-11 place-items-center rounded-full border border-white/20 text-xl">▣</span><div><p class="text-[11px] text-white/80">Active Campaigns</p><p class="text-xl font-black">{{ $activeCampaigns }}</p></div></div>
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 h-12 w-[42%] rounded-tr-[80px] bg-[#006143]/60"></div>
</section>

<section id="programs" class="bg-white py-12 sm:py-14">
    <div class="hc-section grid gap-8 lg:grid-cols-[280px_1fr] lg:items-center">
        <div>
            <p class="text-xs font-extrabold tracking-wider text-emerald-700">OUR PROGRAMS</p>
            <h2 class="mt-2 text-[27px] font-black leading-tight text-[#063e2c] sm:text-3xl">Changing Lives Through Care &amp; Opportunity</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">We focus on holistic development, providing education, healthcare, nutrition and life skills to help children reach their full potential.</p>
            <a href="{{ route('programs') }}" class="mt-5 inline-flex rounded-full bg-emerald-800 px-5 py-2.5 text-xs font-bold text-white hover:bg-emerald-700">Explore Our Programs&nbsp; →</a>
        </div>
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach([
                ['Education','Quality learning for a brighter future.','▣','bg-emerald-600'],
                ['Healthcare','Better health, stronger tomorrows.','♡','bg-amber-400'],
                ['Nutrition','Healthy children, healthy communities.','✂','bg-emerald-600'],
                ['Life Skills','Building confident, independent lives.','♧','bg-amber-400'],
            ] as $program)
                <article class="rounded-xl border border-slate-200 bg-white p-5 shadow-[0_5px_20px_rgba(15,23,42,.05)] transition hover:-translate-y-1 hover:shadow-lg">
                    <span class="grid h-12 w-12 place-items-center rounded-full {{ $program[3] }} text-xl font-bold text-white">{{ $program[2] }}</span>
                    <h3 class="mt-4 text-base font-extrabold text-[#063e2c]">{{ $program[0] }}</h3>
                    <p class="mt-2 text-xs leading-5 text-slate-600">{{ $program[1] }}</p>
                    <a href="{{ route('programs') }}" class="mt-6 inline-block text-[11px] font-extrabold text-emerald-800">Learn More&nbsp; →</a>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="campaigns" class="bg-[#eff9f5] py-12 sm:py-14">
    <div class="hc-section grid gap-8 lg:grid-cols-[280px_1fr]">
        <div>
            <p class="text-xs font-extrabold tracking-wider text-emerald-700">FEATURED CAMPAIGNS</p>
            <h2 class="mt-2 text-[27px] font-black leading-tight text-[#063e2c] sm:text-3xl">Help Us Make a Difference</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">Support our current campaigns and be part of something bigger. Your donation brings hope, provides care and creates lasting change.</p>
            <a href="{{ route('donate') }}" class="mt-5 inline-flex rounded-full bg-emerald-800 px-5 py-2.5 text-xs font-bold text-white hover:bg-emerald-700">View All Campaigns&nbsp; →</a>
        </div>
        <div class="grid gap-4 md:grid-cols-3">
            @forelse($campaignList as $i => $campaign)
                @php $target=max((float)$campaign->target_amount,1); $raised=(float)$campaign->current_amount; $percent=min(100,round($raised/$target*100)); @endphp
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="relative h-28 overflow-hidden"><img src="{{ $campaign->banner ? asset('storage/'.$campaign->banner) : $campaignImages[$i] }}" alt="{{ $campaign->title }}" class="h-full w-full object-cover"><span class="absolute bottom-2 left-3 rounded bg-emerald-600 px-2.5 py-1 text-[9px] font-extrabold text-white">{{ $i === 0 ? 'Education' : ($i === 1 ? 'Healthcare' : 'Nutrition') }}</span></div>
                    <div class="p-3.5"><h3 class="text-sm font-extrabold text-[#063e2c]">{{ $campaign->title }}</h3><p class="mt-1 text-xs"><strong class="text-emerald-700">{{ $campaign->currency ?? '₦' }} {{ number_format($raised,0) }}</strong> <span class="text-slate-400">/ {{ number_format($target,0) }}</span></p><div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-200"><div class="h-full rounded-full bg-emerald-600" style="width:{{ $percent }}%"></div></div><div class="mt-1 flex justify-between text-[9px] text-slate-500"><span>{{ $percent }}%</span><span>Ends: {{ optional($campaign->end_date)->format('M d, Y') ?? 'Soon' }}</span></div></div>
                </article>
            @empty
                @foreach(['Back to School Support','Medical Support Fund','Food for All Children'] as $i => $name)
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"><img src="{{ $campaignImages[$i] }}" class="h-28 w-full object-cover" alt="{{ $name }}"><div class="p-3.5"><span class="rounded bg-emerald-600 px-2 py-1 text-[9px] font-bold text-white">{{ $i===0?'Education':($i===1?'Healthcare':'Nutrition') }}</span><h3 class="mt-2 text-sm font-extrabold text-[#063e2c]">{{ $name }}</h3><p class="mt-1 text-xs text-slate-500">Help create a brighter future.</p><div class="mt-3 h-2 rounded-full bg-slate-200"><div class="h-full w-2/3 rounded-full bg-emerald-600"></div></div></div></article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section id="events" class="bg-white py-12 sm:py-14">
    <div class="hc-section grid gap-8 lg:grid-cols-[280px_1fr]">
        <div>
            <p class="text-xs font-extrabold tracking-wider text-emerald-700">UPCOMING EVENTS</p>
            <h2 class="mt-2 text-[27px] font-black leading-tight text-[#063e2c] sm:text-3xl">Join Our Community</h2>
            <p class="mt-3 text-sm leading-6 text-slate-600">Be part of our events, volunteer activities and community programs. Together, we can create lasting change for every child.</p>
            <a href="#events" class="mt-5 inline-flex rounded-full bg-emerald-800 px-5 py-2.5 text-xs font-bold text-white hover:bg-emerald-700">View All Events&nbsp; →</a>
        </div>
        <div class="grid gap-4 md:grid-cols-3">
            @forelse($eventList as $i => $event)
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"><img src="{{ $event->image ? asset('storage/'.$event->image) : $eventImages[$i] }}" alt="{{ $event->title }}" class="h-28 w-full object-cover"><div class="flex gap-3 p-3.5"><div class="h-fit rounded-lg bg-white px-2 py-1.5 text-center shadow ring-1 ring-slate-200"><b class="block text-sm text-emerald-800">{{ $event->starts_at->format('d') }}</b><small class="text-[8px] font-bold uppercase text-emerald-700">{{ $event->starts_at->format('M') }}</small></div><div><h3 class="text-sm font-extrabold text-[#063e2c]">{{ $event->title }}</h3><p class="mt-1 text-[10px] text-slate-500">⌖ {{ $event->location ?: 'Hope & Care Center' }}</p><p class="mt-1 text-[10px] text-slate-500">◷ {{ $event->starts_at->format('g:i A') }}{{ $event->ends_at ? ' – '.$event->ends_at->format('g:i A') : '' }}</p></div></div></article>
            @empty
                @foreach(['Charity Fundraising Gala','Community Volunteer Day','Educational Workshop'] as $i => $name)
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm"><img src="{{ $eventImages[$i] }}" class="h-28 w-full object-cover" alt="{{ $name }}"><div class="flex gap-3 p-3.5"><div class="rounded-lg bg-emerald-50 px-2 py-1.5 text-center"><b class="block text-sm text-emerald-800">{{ [20,5,28][$i] }}</b><small class="text-[8px] font-bold uppercase text-emerald-700">{{ ['May','Jun','Jun'][$i] }}</small></div><div><h3 class="text-sm font-extrabold text-[#063e2c]">{{ $name }}</h3><p class="mt-1 text-[10px] text-slate-500">⌖ Hope &amp; Care Center</p><p class="mt-1 text-[10px] text-slate-500">◷ 10:00 AM – 2:00 PM</p></div></div></article>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<section class="relative overflow-hidden bg-[#00452f] text-white">
    <img src="{{ $heroImages[1] }}" alt="Hope & Care community" class="absolute inset-0 h-full w-full object-cover opacity-45"><div class="absolute inset-0 bg-[#00452f]/85"></div>
    <div class="hc-section relative grid gap-8 py-12 md:grid-cols-[1fr_330px] md:items-center">
        <div><p class="text-xs font-extrabold tracking-wider text-amber-400">OUR COMMUNITY</p><h2 class="mt-2 text-3xl font-black">Built with partners who care.</h2><p class="mt-3 max-w-[470px] text-sm leading-6 text-white/90">Donors, volunteers, educators, healthcare partners and local organizations help create lasting impact.</p><a href="{{ route('contact') }}" class="mt-5 inline-flex rounded-full bg-white px-5 py-2.5 text-xs font-bold text-emerald-900 hover:bg-emerald-50">View All Events&nbsp; →</a></div>
        <div class="rounded-2xl border border-white/20 bg-emerald-950/40 p-5 backdrop-blur-sm"><p class="text-3xl text-amber-300">“</p><p class="text-sm leading-6 text-white">When a community comes together, a child can see possibilities beyond today.</p><p class="mt-3 text-xs font-bold text-amber-300">— Hope &amp; Care Orphanage</p><a href="{{ route('contact') }}" class="mt-4 inline-flex rounded-full bg-amber-400 px-5 py-2 text-xs font-extrabold text-emerald-950">Partner With Us&nbsp; →</a></div>
    </div>
</section>
@endsection
