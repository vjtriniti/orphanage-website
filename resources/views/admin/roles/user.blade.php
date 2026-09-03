@extends('layouts.admin')
@section('title','Assign Roles')
@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div><p class="text-sm font-bold uppercase tracking-widest text-emerald-600">Security</p><h1 class="text-3xl font-black">Assign roles</h1><p class="mt-1 text-slate-500">Choose the permissions this staff account receives through its roles.</p></div>
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="mb-6"><h2 class="text-xl font-black">{{ $user->name }}</h2><p class="text-sm text-slate-500">{{ $user->email }}</p></div>
        <form method="POST" action="{{ route('admin.users.roles.update', $user) }}" class="space-y-3">
            @csrf @method('PUT')
            @foreach($roles as $role)
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 p-4 hover:bg-slate-50">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" @checked($user->roles->contains($role->id)) class="mt-1 rounded border-slate-300">
                    <span><span class="font-bold">{{ $role->label ?: $role->name }}</span><small class="block text-slate-400">{{ $role->name }}</small></span>
                </label>
            @endforeach
            <div class="flex gap-3 pt-4"><a href="{{ route('admin.roles.index') }}" class="rounded-xl border px-5 py-3 font-bold">Cancel</a><button class="rounded-xl bg-emerald-700 px-5 py-3 font-bold text-white">Save roles</button></div>
        </form>
    </div>
</div>
@endsection
