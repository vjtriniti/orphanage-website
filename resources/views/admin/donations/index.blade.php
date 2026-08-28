<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donations | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main class="mx-auto max-w-7xl p-6">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-emerald-700">Admin</p>
                <h1 class="mt-1 text-3xl font-bold">Donation Management</h1>
                <p class="mt-2 text-slate-600">Review and update incoming donation records.</p>
            </div>
            <a href="{{ route('home') }}" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold">View site</a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-emerald-50 p-4 text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-slate-100 text-slate-600">
                        <tr>
                            <th class="px-5 py-4">Donor</th>
                            <th class="px-5 py-4">Amount</th>
                            <th class="px-5 py-4">Method</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4">Date</th>
                            <th class="px-5 py-4">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($donations as $donation)
                            <tr>
                                <td class="px-5 py-4"><div class="font-semibold">{{ $donation->donor_name }}</div><div class="text-slate-500">{{ $donation->email }}</div></td>
                                <td class="px-5 py-4 font-semibold">{{ $donation->currency }} {{ number_format((float) $donation->amount, 2) }}</td>
                                <td class="px-5 py-4">{{ $donation->payment_method ?: 'Not selected' }}</td>
                                <td class="px-5 py-4"><span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase">{{ $donation->status }}</span></td>
                                <td class="px-5 py-4 text-slate-500">{{ $donation->created_at->format('M d, Y') }}</td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('admin.donations.status', $donation) }}" class="flex gap-2">
                                        @csrf @method('PATCH')
                                        <select name="status" class="rounded-lg border border-slate-300 px-2 py-2 text-xs">
                                            @foreach(['pending', 'completed', 'failed'] as $status)
                                                <option value="{{ $status }}" @selected($donation->status === $status)>{{ ucfirst($status) }}</option>
                                            @endforeach
                                        </select>
                                        <button class="rounded-lg bg-emerald-700 px-3 py-2 text-xs font-semibold text-white">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500">No donations recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-100 p-5">{{ $donations->links() }}</div>
        </div>
    </main>
</body>
</html>
