@extends('layouts.admin')
@section('title','Roles & Permissions')
@section('content')
<div class="space-y-6">
    <div><p class="text-sm font-bold uppercase tracking-widest text-emerald-600">Security</p><h1 class="text-3xl font-black">Roles & Permissions</h1><p class="mt-1 text-slate-500">Control what each staff role can access and manage.</p></div>
    @if(session('success'))<div class="rounded-xl bg-emerald-50 p-4 font-semibold text-emerald-800">{{ session('success') }}</div>@endif
    <div class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-black">Create role</h2>
            <form method="POST" action="{{ route('admin.roles.store') }}" class="mt-4 space-y-4">@csrf
                <input name="name" placeholder="finance-manager" class="w-full rounded-xl border px-4 py-3" required>
                <input name="label" placeholder="Finance Manager" class="w-full rounded-xl border px-4 py-3">
                <div class="max-h-64 space-y-2 overflow-auto">@foreach($permissions as $permission)<label class="flex gap-3 rounded-lg p-2 hover:bg-slate-50"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="mt-1"><span><b>{{ $permission->label ?: $permission->name }}</b><small class="block text-slate-400">{{ $permission->name }}</small></span></label>@endforeach</div>
                <button class="w-full rounded-xl bg-emerald-700 px-4 py-3 font-bold text-white">Create role</button>
            </form>
        </div>
        <div class="xl:col-span-2 space-y-4">
            @forelse($roles as $role)
                <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                    <div class="flex items-center justify-between gap-4"><div><h2 class="font-black">{{ $role->label ?: $role->name }}</h2><p class="text-xs text-slate-400">{{ $role->name }} · {{ $role->users->count() }} user(s)</p></div>@if($role->name!=='super-admin')<form method="POST" action="{{ route('admin.roles.destroy',$role) }}">@csrf @method('DELETE')<button class="text-sm font-bold text-rose-600">Delete</button></form>@endif</div>
                    <form method="POST" action="{{ route('admin.roles.update',$role) }}" class="mt-5">@csrf @method('PUT')<input name="label" value="{{ $role->label }}" class="mb-4 w-full rounded-xl border px-4 py-3"><div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">@foreach($permissions as $permission)<label class="flex items-center gap-2 rounded-lg border p-2 text-sm"><input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked($role->permissions->contains($permission->id))>{{ $permission->label ?: $permission->name }}</label>@endforeach</div><button class="mt-4 rounded-xl border border-emerald-200 px-4 py-2 text-sm font-bold text-emerald-700">Save permissions</button></form>
                    @if($role->users->isNotEmpty())<div class="mt-5 flex flex-wrap gap-2">@foreach($role->users as $user)<a href="{{ route('admin.users.roles.edit',$user) }}" class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">{{ $user->name }} · edit roles</a>@endforeach</div>@endif
                </div>
            @empty<div class="rounded-2xl bg-white p-10 text-center text-slate-400">No roles created yet.</div>@endforelse
        </div>
    </div>
</div>
@endsection
