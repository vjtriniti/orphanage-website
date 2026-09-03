@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 text-slate-900">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="hidden w-72 shrink-0 bg-emerald-950 text-white lg:flex lg:flex-col">
            <div class="border-b border-emerald-800 px-7 py-7">
                <a href="{{ route('home') }}" class="block">
                    <div class="text-2xl font-black tracking-tight">Hope &amp; Care</div>
                    <div class="mt-1 text-xs font-bold uppercase tracking-[0.35em] text-amber-300">Orphanage</div>
                </a>
            </div>

            <nav class="flex-1 space-y-1 px-4 py-6 text-sm font-semibold">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl bg-emerald-800 px-4 py-3 text-white shadow-sm">
                    <span class="text-lg">⌂</span> Dashboard
                </a>

                <p class="px-4 pb-2 pt-7 text-[11px] font-bold uppercase tracking-[0.2em] text-emerald-300">Donor Portal</p>
                <a href="{{ route('donate') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">♡ <span>Make a Donation</span></a>
                <a href="#donations" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">↻ <span>Donation History</span></a>
                <a href="#campaigns" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">◇ <span>My Campaigns</span></a>
                <a href="#donations" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">▣ <span>Receipts &amp; Invoices</span></a>

                <p class="border-t border-emerald-800 px-4 pb-2 pt-7 text-[11px] font-bold uppercase tracking-[0.2em] text-emerald-300">My Account</p>
                <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">♙ <span>Profile</span></a>
                <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">⚙ <span>Account Settings</span></a>
                <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">◇ <span>Security</span></a>
                <a href="#notifications" class="flex items-center justify-between rounded-xl px-4 py-3 hover:bg-emerald-900"><span class="flex items-center gap-3">♧ Notifications</span><span class="rounded-full bg-emerald-600 px-2 py-0.5 text-[10px]">New</span></a>

                <p class="border-t border-emerald-800 px-4 pb-2 pt-7 text-[11px] font-bold uppercase tracking-[0.2em] text-emerald-300">Get Involved</p>
                <a href="{{ route('volunteer.apply') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">♧ <span>Volunteer</span></a>
                <a href="{{ route('home') }}#programs" class="flex items-center gap-3 rounded-xl px-4 py-3 hover:bg-emerald-900">▣ <span>Programs &amp; Events</span></a>
            </nav>

            <div class="m-4 rounded-2xl bg-emerald-800 p-5">
                <p class="font-black">Change a life today</p>
                <p class="mt-2 text-xs leading-5 text-emerald-100">Your support helps provide care, education and opportunity.</p>
                <a href="{{ route('donate') }}" class="mt-4 inline-flex rounded-lg bg-amber-400 px-4 py-2 text-xs font-black text-emerald-950 hover:bg-amber-300">Make a Donation</a>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="flex h-20 items-center gap-4 px-5 sm:px-8">
                    <a href="{{ route('home') }}" class="font-black text-emerald-900 lg:hidden">Hope &amp; Care</a>
                    <div class="hidden max-w-md flex-1 sm:block">
                        <div class="flex items-center rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-400 ring-1 ring-slate-200">⌕ <span class="ml-3">Search anything...</span></div>
                    </div>
                    <div class="ml-auto flex items-center gap-4">
                        <button type="button" class="relative rounded-xl p-2 text-xl text-slate-600 hover:bg-slate-100" aria-label="Notifications">♧<span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-emerald-600"></span></button>
                        <a href="#notifications" class="rounded-xl p-2 text-xl text-slate-600 hover:bg-slate-100" aria-label="Messages">✉</a>
                        <div class="hidden border-l border-slate-200 pl-4 sm:block">
                            <p class="text-sm font-black">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500">Donor</p>
                        </div>
                    </div>
                </div>
            </header>

            <div class="mx-auto max-w-[1500px] px-5 py-8 sm:px-8 lg:px-10">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-end">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-700">Donor Dashboard</p>
                        <h1 class="mt-2 text-3xl font-black tracking-tight sm:text-4xl">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                        <p class="mt-2 text-slate-500">Thank you for your generosity. Your support is changing lives.</p>
                    </div>
                    <a href="{{ route('donate') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-700 px-6 py-3 font-bold text-white shadow-sm hover:bg-emerald-800">+ Make a Donation</a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-slate-500">Total Donated</p><p class="mt-2 text-3xl font-black">₦{{ number_format($total, 0) }}</p></div><span class="grid h-12 w-12 place-items-center rounded-full bg-emerald-100 text-xl text-emerald-700">♡</span></div>
                        <p class="mt-4 text-xs font-bold text-emerald-700">₦{{ number_format($yearTotal, 0) }} this year</p>
                    </div>
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-slate-500">Total Donations</p><p class="mt-2 text-3xl font-black">{{ $count }}</p></div><span class="grid h-12 w-12 place-items-center rounded-full bg-emerald-100 text-xl text-emerald-700">▣</span></div>
                        <p class="mt-4 text-xs font-bold text-emerald-700">{{ $completedCount }} completed gifts</p>
                    </div>
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-slate-500">Active Campaigns</p><p class="mt-2 text-3xl font-black">{{ $activeCampaigns }}</p></div><span class="grid h-12 w-12 place-items-center rounded-full bg-amber-100 text-xl text-amber-600">◇</span></div>
                        <a href="#campaigns" class="mt-4 inline-block text-xs font-bold text-amber-600">View campaigns →</a>
                    </div>
                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <div class="flex items-start justify-between"><div><p class="text-sm font-semibold text-slate-500">Latest Activity</p><p class="mt-2 text-lg font-black">{{ $donations->first()?->created_at?->format('M d, Y') ?? 'No donations yet' }}</p></div><span class="grid h-12 w-12 place-items-center rounded-full bg-sky-100 text-xl text-sky-600">◷</span></div>
                        <p class="mt-4 text-xs font-bold text-slate-500">Your most recent account activity</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-6 xl:grid-cols-12">
                    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-6" id="overview">
                        <div class="flex items-center justify-between"><div><h2 class="text-lg font-black">Donation Overview</h2><p class="text-sm text-slate-500">Your completed gifts over the last six months</p></div><span class="rounded-lg bg-slate-50 px-3 py-2 text-xs font-bold text-slate-600">Last 6 months</span></div>
                        <div class="mt-6 overflow-hidden">
                            <svg viewBox="0 0 520 230" class="h-64 w-full" role="img" aria-label="Donation overview chart">
                                <line x1="40" y1="190" x2="500" y2="190" stroke="currentColor" class="text-slate-200" />
                                <line x1="40" y1="115" x2="500" y2="115" stroke="currentColor" class="text-slate-100" />
                                <line x1="40" y1="45" x2="500" y2="45" stroke="currentColor" class="text-slate-100" />
                                <polyline points="{{ $chartPoints }}" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-600" />
                                @foreach($months as $index => $month)
                                    @php $x = 42 + ($index * 94); $y = 190 - (($month['amount'] / $chartMax) * 145); @endphp
                                    <circle cx="{{ $x }}" cy="{{ $y }}" r="5" class="fill-emerald-600" />
                                    <text x="{{ $x }}" y="215" text-anchor="middle" font-size="12" fill="currentColor" class="text-slate-500">{{ $month['label'] }}</text>
                                @endforeach
                            </svg>
                        </div>
                        <div class="mt-1 flex items-center justify-center gap-2 text-xs font-semibold text-slate-500"><span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>Total completed donations</div>
                    </section>

                    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-3" id="notifications">
                        <div class="flex items-center justify-between"><div><h2 class="text-lg font-black">Recent Activity</h2><p class="text-sm text-slate-500">Latest account updates</p></div><span class="text-xl text-emerald-600">♡</span></div>
                        <div class="mt-5 space-y-1">
                            @forelse($donations->take(4) as $donation)
                                <div class="flex gap-3 border-b border-slate-100 py-4 last:border-0"><span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-emerald-50 text-emerald-700">♡</span><div class="min-w-0 flex-1"><p class="text-sm font-bold">Donation of {{ $donation->currency }} {{ number_format($donation->amount, 0) }}</p><p class="mt-1 text-xs text-slate-500">{{ ucfirst($donation->status) }} · {{ $donation->created_at->format('M d, Y') }}</p></div></div>
                            @empty
                                <div class="py-8 text-sm text-slate-500">No activity yet. Your first donation will appear here.</div>
                            @endforelse
                        </div>
                    </section>

                    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-3">
                        <h2 class="text-lg font-black">Your Profile</h2>
                        <div class="mt-5 flex items-center gap-4"><div class="grid h-16 w-16 place-items-center rounded-full bg-emerald-100 text-xl font-black text-emerald-800">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><div><p class="font-black">{{ auth()->user()->name }}</p><p class="text-xs text-slate-500">Hope &amp; Care donor</p></div></div>
                        <div class="mt-6 border-t border-slate-100 pt-5"><p class="text-xs font-bold uppercase tracking-wider text-slate-400">Email</p><p class="mt-1 break-all text-sm">{{ auth()->user()->email }}</p></div>
                        <a href="{{ route('profile') }}" class="mt-5 block rounded-xl border border-emerald-200 px-4 py-3 text-center text-sm font-bold text-emerald-700 hover:bg-emerald-50">View Full Profile</a>
                    </section>
                </div>

                <div class="mt-6 grid gap-6 xl:grid-cols-12" id="donations">
                    <section class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 xl:col-span-9">
                        <div class="flex items-center justify-between border-b border-slate-100 p-6"><div><h2 class="text-lg font-black">Recent Donations</h2><p class="text-sm text-slate-500">A record of your latest contributions</p></div><a href="{{ route('donate') }}" class="text-sm font-bold text-emerald-700">Give again →</a></div>
                        <div class="overflow-x-auto"><table class="min-w-full text-left text-sm"><thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500"><tr><th class="px-6 py-4">Date</th><th class="px-6 py-4">Amount</th><th class="px-6 py-4">Payment Method</th><th class="px-6 py-4">Status</th></tr></thead><tbody class="divide-y divide-slate-100">@forelse($donations as $donation)<tr class="hover:bg-slate-50"><td class="whitespace-nowrap px-6 py-4">{{ $donation->created_at->format('M d, Y') }}</td><td class="whitespace-nowrap px-6 py-4 font-black">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</td><td class="px-6 py-4">{{ $donation->payment_method ?: '—' }}</td><td class="px-6 py-4"><span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold capitalize text-emerald-700">{{ $donation->status }}</span></td></tr>@empty<tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Your donation history will appear here.</td></tr>@endforelse</tbody></table></div>
                        <div class="border-t border-slate-100 p-5">{{ $donations->links() }}</div>
                    </section>

                    <section class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 xl:col-span-3" id="campaigns">
                        <h2 class="text-lg font-black">Quick Actions</h2>
                        <div class="mt-5 space-y-3">
                            <a href="{{ route('donate') }}" class="flex items-center justify-between rounded-xl bg-emerald-50 p-4 hover:bg-emerald-100"><span><span class="block text-sm font-black text-emerald-800">Make a Donation</span><span class="text-xs text-slate-500">Support a campaign</span></span><span class="text-xl text-emerald-700">→</span></a>
                            <a href="{{ route('volunteer.apply') }}" class="flex items-center justify-between rounded-xl bg-slate-50 p-4 hover:bg-slate-100"><span><span class="block text-sm font-black">Become a Volunteer</span><span class="text-xs text-slate-500">Give your time</span></span><span class="text-xl">→</span></a>
                            <a href="{{ route('profile') }}" class="flex items-center justify-between rounded-xl bg-slate-50 p-4 hover:bg-slate-100"><span><span class="block text-sm font-black">Account Settings</span><span class="text-xs text-slate-500">Manage your profile</span></span><span class="text-xl">→</span></a>
                            <a href="{{ route('home') }}#programs" class="flex items-center justify-between rounded-xl bg-slate-50 p-4 hover:bg-slate-100"><span><span class="block text-sm font-black">Explore Programs</span><span class="text-xs text-slate-500">See where help is needed</span></span><span class="text-xl">→</span></a>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
