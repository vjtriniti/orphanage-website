@extends('layouts.app')

@section('content')
<style>
    .donor-dashboard { font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
    .donor-card { border: 1px solid #e8eeeb; box-shadow: 0 2px 10px rgba(15, 23, 42, .045); }
    .donor-sidebar { background: linear-gradient(180deg, #004b36 0%, #003f2f 100%); }
    .donor-sidebar a { transition: background .18s ease, transform .18s ease; }
    .donor-sidebar a:hover { background: rgba(255,255,255,.08); }
    .donor-sidebar .active-link { background: #087c46; box-shadow: inset 0 0 0 1px rgba(255,255,255,.04); }
    .chart-grid { stroke: #e7ece9; stroke-width: 1; }
    .chart-line { stroke: #148346; stroke-width: 3; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    .chart-area { fill: url(#donorArea); }
</style>

<div class="donor-dashboard min-h-screen bg-[#f7f9f8] text-slate-900" x-data="{menu:false}">
    <div x-show="menu" x-cloak @click="menu=false" class="fixed inset-0 z-40 bg-slate-950/50 lg:hidden"></div>

    <div class="flex min-h-screen">
        <aside :class="menu ? 'translate-x-0' : '-translate-x-full'" class="donor-sidebar fixed inset-y-0 left-0 z-50 flex w-[270px] -translate-x-full flex-col text-white shadow-2xl transition-transform duration-200 lg:static lg:translate-x-0 lg:shadow-none">
            <div class="px-6 pb-6 pt-7">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="relative grid h-12 w-12 place-items-center">
                        <div class="absolute inset-0 rounded-full border-[3px] border-amber-400"></div>
                        <span class="relative text-2xl text-white">⌂</span>
                        <span class="absolute -top-1 left-1 h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                        <span class="absolute -top-1 right-1 h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                    </div>
                    <div>
                        <div class="text-[22px] font-serif leading-none tracking-tight">Hope &amp; Care</div>
                        <div class="mt-1 text-[11px] font-semibold tracking-[.32em] text-amber-300">ORPHANAGE</div>
                    </div>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto px-4 pb-4 text-[14px] font-medium">
                <a href="{{ route('dashboard') }}" class="active-link flex items-center gap-4 rounded-lg px-4 py-3.5 font-semibold">
                    <i data-lucide="house" class="h-[18px] w-[18px]"></i><span>Dashboard</span>
                </a>

                <p class="px-4 pb-2 pt-8 text-[11px] font-semibold uppercase tracking-[.08em] text-emerald-200">Donor Portal</p>
                <a href="{{ route('donate') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="heart-handshake" class="h-[18px] w-[18px]"></i><span>My Donations</span></a>
                <a href="{{ route('donor.donations') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="history" class="h-[18px] w-[18px]"></i><span>Donation History</span></a>
                <a href="{{ route('donor.recurring') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="refresh-cw" class="h-[18px] w-[18px]"></i><span>Recurring Donations</span></a>
                <a href="{{ route('programs') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="hand-heart" class="h-[18px] w-[18px]"></i><span>My Campaigns</span></a>
                <a href="{{ route('donor.donations') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="file-text" class="h-[18px] w-[18px]"></i><span>Receipts &amp; Invoices</span></a>

                <div class="my-3 border-t border-white/10"></div>
                <p class="px-4 pb-2 pt-2 text-[11px] font-semibold uppercase tracking-[.08em] text-emerald-200">My Account</p>
                <a href="{{ route('profile') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="user-round" class="h-[18px] w-[18px]"></i><span>Profile</span></a>
                <a href="{{ route('profile') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="settings" class="h-[18px] w-[18px]"></i><span>Account Settings</span></a>
                <a href="{{ route('profile') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="shield-check" class="h-[18px] w-[18px]"></i><span>Security</span></a>
                <a href="{{ route('profile') }}" class="flex items-center justify-between rounded-lg px-4 py-3"><span class="flex items-center gap-4"><i data-lucide="credit-card" class="h-[18px] w-[18px]"></i><span>Payment Methods</span></span></a>
                <a href="{{ route('donor.notifications') }}" class="flex items-center justify-between rounded-lg px-4 py-3"><span class="flex items-center gap-4"><i data-lucide="bell" class="h-[18px] w-[18px]"></i><span>Notifications</span></span><span class="grid min-w-6 place-items-center rounded-full bg-emerald-500 px-2 py-0.5 text-[11px] font-bold">{{ $unreadNotifications }}</span></a>

                <div class="my-3 border-t border-white/10"></div>
                <p class="px-4 pb-2 pt-2 text-[11px] font-semibold uppercase tracking-[.08em] text-emerald-200">Get Involved</p>
                <a href="{{ route('volunteer.apply') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="users-round" class="h-[18px] w-[18px]"></i><span>Volunteer</span></a>
                <a href="{{ route('programs') }}" class="flex items-center gap-4 rounded-lg px-4 py-3"><i data-lucide="calendar-days" class="h-[18px] w-[18px]"></i><span>Events</span></a>
            </nav>

            <div class="px-4 pb-5">
                <div class="overflow-hidden rounded-xl bg-[#087b46]">
                    <div class="px-4 pb-3 pt-4">
                        <h3 class="text-[15px] font-bold">Change a life today</h3>
                        <p class="mt-2 max-w-[180px] text-[12px] leading-5 text-emerald-50">Your support brings hope and a brighter future.</p>
                    </div>
                    <div class="px-4 pb-4">
                        <a href="{{ route('donate') }}" class="inline-flex rounded-lg bg-amber-400 px-4 py-2.5 text-[12px] font-bold text-emerald-950 hover:bg-amber-300">Make a Donation</a>
                    </div>
                </div>
                <div class="px-2 pt-8 text-[11px] text-emerald-100/80">© {{ date('Y') }} Hope &amp; Care Orphanage</div>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="sticky top-0 z-30 h-[70px] border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="flex h-full items-center gap-4 px-5 lg:px-7">
                    <button @click="menu=true" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open menu"><i data-lucide="menu" class="h-5 w-5"></i></button>
                    <div class="relative hidden w-[390px] md:block">
                        <input type="search" placeholder="Search anything..." class="h-11 w-full rounded-lg border-0 bg-[#f5f7f8] pl-4 pr-11 text-[13px] text-slate-700 outline-none ring-0 placeholder:text-slate-500 focus:border-0 focus:ring-2 focus:ring-emerald-100">
                        <i data-lucide="search" class="absolute right-4 top-3 h-5 w-5 text-slate-500"></i>
                    </div>
                    <div class="ml-auto flex items-center gap-4">
                        <a href="{{ route('donor.notifications') }}" class="relative rounded-lg p-2 text-slate-600 hover:bg-slate-50"><i data-lucide="bell" class="h-5 w-5"></i><span class="absolute -right-0.5 -top-0.5 grid h-[18px] min-w-[18px] place-items-center rounded-full bg-emerald-700 px-1 text-[9px] font-bold text-white">{{ $unreadNotifications }}</span></a>
                        <a href="{{ route('donor.notifications') }}" class="relative hidden rounded-lg p-2 text-slate-600 hover:bg-slate-50 sm:block"><i data-lucide="mail" class="h-5 w-5"></i><span class="absolute -right-0.5 -top-0.5 grid h-[18px] min-w-[18px] place-items-center rounded-full bg-emerald-700 px-1 text-[9px] font-bold text-white">{{ $unreadNotifications }}</span></a>
                        <div class="hidden h-9 w-px bg-slate-200 sm:block"></div>
                        <div class="hidden text-right sm:block"><div class="text-[14px] font-bold">{{ auth()->user()->name }}</div><div class="text-[11px] text-slate-500">Donor</div></div>
                        <div class="grid h-10 w-10 place-items-center rounded-full bg-gradient-to-br from-emerald-700 to-emerald-500 text-sm font-bold text-white ring-4 ring-emerald-50">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <i data-lucide="chevron-down" class="hidden h-4 w-4 text-slate-500 sm:block"></i>
                    </div>
                </div>
            </header>

            <div class="mx-auto max-w-[1280px] px-5 py-7 lg:px-7 lg:py-8">
                <div class="flex flex-col justify-between gap-5 md:flex-row md:items-center">
                    <div>
                        <h1 class="text-[24px] font-bold tracking-[-.02em] text-[#073d2d] sm:text-[26px]">Welcome back, {{ auth()->user()->name }}! 👋</h1>
                        <p class="mt-1 text-[13px] text-slate-500">Thank you for your generosity. Your support is changing lives.</p>
                    </div>
                    <a href="{{ route('donor.donations') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-emerald-200 bg-white px-4 py-2.5 text-[12px] font-semibold text-emerald-800 shadow-sm hover:bg-emerald-50"><i data-lucide="download" class="h-4 w-4"></i>Download Report</a>
                </div>

                <div class="mt-6 grid gap-4 xl:grid-cols-4">
                    <div class="donor-card rounded-xl bg-white p-5">
                        <div class="flex items-center gap-4">
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-emerald-600 text-white shadow-sm"><i data-lucide="hand-heart" class="h-6 w-6"></i></div>
                            <div><div class="text-[12px] font-medium text-slate-500">Total Donated</div><div class="mt-1 text-[22px] font-bold">₦{{ number_format($total, 0) }}</div></div>
                        </div>
                        <div class="mt-4 flex items-center gap-1 text-[12px] font-semibold text-emerald-700"><i data-lucide="arrow-up" class="h-3.5 w-3.5"></i>{{ $yearTotal > 0 ? 'Your giving this year' : 'Start your giving journey' }}</div>
                    </div>

                    <div class="donor-card rounded-xl bg-white p-5">
                        <div class="flex items-center gap-4">
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-emerald-600 text-white shadow-sm"><i data-lucide="wallet-cards" class="h-6 w-6"></i></div>
                            <div><div class="text-[12px] font-medium text-slate-500">Total Donations</div><div class="mt-1 text-[22px] font-bold">{{ $count }}</div></div>
                        </div>
                        <div class="mt-4 flex items-center gap-1 text-[12px] font-semibold text-emerald-700"><i data-lucide="arrow-up" class="h-3.5 w-3.5"></i>{{ $completedCount }} completed donations</div>
                    </div>

                    <div class="donor-card rounded-xl bg-white p-5">
                        <div class="flex items-center gap-4">
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-amber-500 text-white shadow-sm"><i data-lucide="calendar-days" class="h-6 w-6"></i></div>
                            <div><div class="text-[12px] font-medium text-slate-500">Active Campaigns</div><div class="mt-1 text-[22px] font-bold">{{ $activeCampaigns }}</div></div>
                        </div>
                        <a href="{{ route('programs') }}" class="mt-4 inline-flex text-[12px] font-semibold text-amber-600">View your campaigns</a>
                    </div>

                    <div class="donor-card rounded-xl bg-white p-5">
                        <div class="flex items-center gap-4">
                            <div class="grid h-12 w-12 shrink-0 place-items-center rounded-full bg-blue-500 text-white shadow-sm"><i data-lucide="clock-3" class="h-6 w-6"></i></div>
                            <div><div class="text-[12px] font-medium text-slate-500">Recurring Donations</div><div class="mt-1 text-[22px] font-bold">@if($recurringDonation)₦{{ number_format($recurringDonation->amount, 0) }} <span class="text-[12px] font-semibold">/{{ $recurringDonation->frequency }}</span>@else<span class="text-[17px]">Not active</span>@endif</div></div>
                        </div>
                        <div class="mt-4 text-[12px] font-semibold text-blue-600">@if($recurringDonation && $recurringDonation->next_charge_at)Next: {{ $recurringDonation->next_charge_at->format('M d, Y') }}@else<a href="{{ route('donor.recurring') }}">Set up recurring giving</a>@endif</div>
                    </div>
                </div>

                <div class="mt-5 grid gap-4 xl:grid-cols-12">
                    <section class="donor-card rounded-xl bg-white p-5 xl:col-span-5">
                        <div class="flex items-center justify-between">
                            <h2 class="text-[14px] font-bold">Donation Overview</h2>
                            <button class="inline-flex items-center gap-1 rounded-md border border-slate-200 px-2.5 py-1.5 text-[11px] font-medium text-slate-700">This Year <i data-lucide="chevron-down" class="h-3 w-3"></i></button>
                        </div>
                        <div class="mt-4 overflow-x-auto">
                            <svg viewBox="0 0 560 280" class="h-[250px] w-full min-w-[520px]" role="img" aria-label="Donation overview">
                                <defs><linearGradient id="donorArea" x1="0" x2="0" y1="0" y2="1"><stop offset="0%" stop-opacity=".24"></stop><stop offset="100%" stop-opacity="0"></stop></linearGradient></defs>
                                <line x1="50" y1="35" x2="540" y2="35" class="chart-grid"></line><line x1="50" y1="90" x2="540" y2="90" class="chart-grid"></line><line x1="50" y1="145" x2="540" y2="145" class="chart-grid"></line><line x1="50" y1="200" x2="540" y2="200" class="chart-grid"></line>
                                <text x="5" y="39" font-size="12" fill="#667085">₦{{ number_format($chartMax * 1.0 / 1000, 0) }}K</text>
                                <text x="5" y="94" font-size="12" fill="#667085">₦{{ number_format($chartMax * .75 / 1000, 0) }}K</text>
                                <text x="5" y="149" font-size="12" fill="#667085">₦{{ number_format($chartMax * .5 / 1000, 0) }}K</text>
                                <text x="5" y="204" font-size="12" fill="#667085">₦0</text>
                                <polygon points="50,200 {{ $months->map(function($m,$i) use($chartMax){$x=50+($i*98);$y=200-(($m['amount']/$chartMax)*165);return $x.','.$y;})->implode(' ') }} 540,200" class="chart-area"></polygon>
                                <polyline points="{{ $months->map(function($m,$i) use($chartMax){$x=50+($i*98);$y=200-(($m['amount']/$chartMax)*165);return $x.','.$y;})->implode(' ') }}" class="chart-line"></polyline>
                                @foreach($months as $i=>$month)
                                    @php $x=50+($i*98); $y=200-(($month['amount']/$chartMax)*165); @endphp
                                    <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="#148346"></circle>
                                    <text x="{{ $x }}" y="232" text-anchor="middle" font-size="12" fill="#667085">{{ $month['label'] }}</text>
                                @endforeach
                                <line x1="50" y1="200" x2="540" y2="200" stroke="#dce4df"></line>
                                <circle cx="255" cy="260" r="4" fill="#148346"></circle><text x="267" y="264" font-size="12" font-weight="600" fill="#344054">Total Donations (₦)</text>
                            </svg>
                        </div>
                    </section>

                    <section class="donor-card rounded-xl bg-white p-5 xl:col-span-4">
                        <div class="flex items-center justify-between"><h2 class="text-[14px] font-bold">Recent Activity</h2><a href="{{ route('donor.donations') }}" class="text-[11px] font-semibold text-emerald-700">View all</a></div>
                        <div class="mt-3 divide-y divide-slate-100">
                            @forelse($recentActivity as $activity)
                                <div class="flex items-start gap-3 py-3">
                                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-emerald-50 text-emerald-700"><i data-lucide="heart" class="h-4 w-4"></i></div>
                                    <div class="min-w-0 flex-1"><div class="text-[12px] font-semibold text-slate-800">You made a donation of {{ $activity->currency }}{{ number_format($activity->amount,0) }}</div><div class="mt-0.5 truncate text-[11px] text-slate-500">{{ $activity->campaign ?: ($activity->purpose ?: 'General Donation') }}</div></div>
                                    <time class="shrink-0 text-[10px] text-slate-500">{{ $activity->created_at->diffForHumans(null, true) }} ago</time>
                                </div>
                            @empty
                                <div class="py-10 text-center text-[12px] text-slate-500">No activity yet. Make your first donation.</div>
                            @endforelse
                        </div>
                        <a href="{{ route('donor.donations') }}" class="mt-2 block border-t border-slate-100 pt-3 text-center text-[12px] font-semibold text-emerald-700">View all activity</a>
                    </section>

                    <section class="donor-card rounded-xl bg-white p-5 xl:col-span-3">
                        <h2 class="text-[14px] font-bold">Your Profile</h2>
                        <div class="mt-4 flex items-center gap-3">
                            <div class="grid h-14 w-14 place-items-center rounded-full bg-gradient-to-br from-emerald-700 to-emerald-400 text-xl font-bold text-white ring-4 ring-emerald-50">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                            <div><div class="text-[14px] font-bold">{{ auth()->user()->name }}</div><div class="text-[11px] text-slate-500">Donor since {{ auth()->user()->created_at ? auth()->user()->created_at->format('M Y') : '—' }}</div></div>
                        </div>
                        <div class="mt-5 space-y-4 text-[12px]"><div><div class="text-slate-500">Email</div><div class="mt-1 font-medium">{{ auth()->user()->email }}</div></div><div><div class="text-slate-500">Account</div><div class="mt-1 font-medium">Verified donor account</div></div></div>
                        <a href="{{ route('profile') }}" class="mt-5 block rounded-lg border border-emerald-200 py-2.5 text-center text-[11px] font-semibold text-emerald-800 hover:bg-emerald-50">View Full Profile</a>
                    </section>
                </div>

                <div class="mt-5 grid gap-4 xl:grid-cols-12">
                    <section class="donor-card overflow-hidden rounded-xl bg-white xl:col-span-9">
                        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4"><h2 class="text-[14px] font-bold">Recent Donations</h2><a href="{{ route('donor.donations') }}" class="text-[11px] font-semibold text-emerald-700">View all donations</a></div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-[11px]">
                                <thead class="bg-[#fafbfb] text-slate-600"><tr><th class="px-5 py-3 font-semibold">Date</th><th class="px-5 py-3 font-semibold">Campaign</th><th class="px-5 py-3 font-semibold">Amount</th><th class="px-5 py-3 font-semibold">Payment Method</th><th class="px-5 py-3 font-semibold">Status</th><th class="px-5 py-3 text-center font-semibold">Receipt</th></tr></thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($donations->take(5) as $d)
                                        <tr class="hover:bg-emerald-50/30">
                                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-700">{{ $d->created_at->format('M d, Y') }}</td>
                                            <td class="max-w-[180px] truncate px-5 py-3.5 font-medium">{{ $d->campaign ?: ($d->purpose ?: 'General Donation') }}</td>
                                            <td class="whitespace-nowrap px-5 py-3.5 font-bold">{{ $d->currency }}{{ number_format($d->amount,0) }}</td>
                                            <td class="px-5 py-3.5"><span class="font-semibold">{{ $d->payment_method ? ucfirst($d->payment_method) : '—' }}</span></td>
                                            <td class="px-5 py-3.5"><span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-semibold capitalize text-emerald-700">{{ $d->status }}</span></td>
                                            <td class="px-5 py-3.5 text-center">@if($d->status === 'completed')<a href="{{ route('donations.receipt', $d) }}" class="inline-grid h-7 w-7 place-items-center rounded-md border border-slate-200 text-slate-600 hover:border-emerald-200 hover:text-emerald-700" title="Download receipt"><i data-lucide="file-down" class="h-4 w-4"></i></a>@else<span class="text-slate-300">—</span>@endif</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">Your donation history will appear here.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="border-t border-slate-100 px-5 py-3 text-center"><a href="{{ route('donor.donations') }}" class="text-[11px] font-semibold text-emerald-700">View all donations</a></div>
                    </section>

                    <aside class="donor-card rounded-xl bg-white p-5 xl:col-span-3">
                        <h2 class="text-[14px] font-bold">Quick Actions</h2>
                        <div class="mt-3 space-y-2.5">
                            <a href="{{ route('donate') }}" class="flex items-center gap-3 rounded-lg bg-[#f7f9f8] p-3 hover:bg-emerald-50"><span class="grid h-8 w-8 place-items-center rounded-md bg-emerald-100 text-emerald-700"><i data-lucide="wallet-cards" class="h-4 w-4"></i></span><span class="min-w-0 flex-1"><b class="block text-[11px] text-emerald-800">Make a Donation</b><small class="text-[10px] text-slate-500">Support a campaign</small></span><i data-lucide="chevron-right" class="h-4 w-4 text-slate-500"></i></a>
                            <a href="{{ route('donor.recurring') }}" class="flex items-center gap-3 rounded-lg bg-[#f7f9f8] p-3 hover:bg-emerald-50"><span class="grid h-8 w-8 place-items-center rounded-md bg-emerald-100 text-emerald-700"><i data-lucide="refresh-cw" class="h-4 w-4"></i></span><span class="min-w-0 flex-1"><b class="block text-[11px] text-emerald-800">Start Recurring Donation</b><small class="text-[10px] text-slate-500">Give monthly</small></span><i data-lucide="chevron-right" class="h-4 w-4 text-slate-500"></i></a>
                            <a href="{{ route('programs') }}" class="flex items-center gap-3 rounded-lg bg-[#f7f9f8] p-3 hover:bg-emerald-50"><span class="grid h-8 w-8 place-items-center rounded-md bg-rose-50 text-rose-600"><i data-lucide="calendar-heart" class="h-4 w-4"></i></span><span class="min-w-0 flex-1"><b class="block text-[11px] text-emerald-800">View All Campaigns</b><small class="text-[10px] text-slate-500">See where you can help</small></span><i data-lucide="chevron-right" class="h-4 w-4 text-slate-500"></i></a>
                            <a href="{{ route('donor.donations') }}" class="flex items-center gap-3 rounded-lg bg-[#f7f9f8] p-3 hover:bg-emerald-50"><span class="grid h-8 w-8 place-items-center rounded-md bg-blue-50 text-blue-600"><i data-lucide="file-text" class="h-4 w-4"></i></span><span class="min-w-0 flex-1"><b class="block text-[11px] text-emerald-800">Download Receipt</b><small class="text-[10px] text-slate-500">Get your donation receipt</small></span><i data-lucide="chevron-right" class="h-4 w-4 text-slate-500"></i></a>
                        </div>
                    </aside>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>document.addEventListener('DOMContentLoaded',()=>{if(window.lucide){lucide.createIcons();}});</script>
@endsection
