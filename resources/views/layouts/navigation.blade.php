<nav x-data="{ open: false }" class="relative z-10 border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-10">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-700 text-sm font-bold text-white">B</span>
                    <span class="text-base font-semibold tracking-tight text-slate-900">Bonnetje Bij</span>
                </a>
                <div class="hidden items-center gap-7 sm:flex">
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-emerald-800' : 'text-slate-500 hover:text-slate-900' }}">Overview</a>
                    <a href="{{ route('expenses.create') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900">Add expense</a>
                </div>
            </div>
            <div class="hidden items-center gap-4 sm:flex">
                <span class="text-sm text-slate-500">{{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900">Profile</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Log out</button></form>
            </div>
            <button type="button" @click="open = !open" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 sm:hidden" aria-label="Toggle navigation">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
        </div>
    </div>
    <div x-show="open" x-transition class="border-t border-slate-100 bg-white px-4 py-3 sm:hidden">
        <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Overview</a>
        <a href="{{ route('expenses.create') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Add expense</a>
        <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Profile</a>
        <form method="POST" action="{{ route('logout') }}" class="px-3 py-2">@csrf<button class="text-sm font-medium text-slate-500">Log out</button></form>
    </div>
</nav>
