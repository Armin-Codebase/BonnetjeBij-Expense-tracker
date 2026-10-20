<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bonnetje Bij — make sense of your spending</title>
    <link rel="preconnect" href="https://fonts.bunny.net"><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))) @vite(['resources/css/app.css', 'resources/js/app.js']) @endif
</head>
<body class="min-h-screen bg-[#f7f8f5] font-sans text-slate-900 antialiased">
    <header class="mx-auto flex max-w-7xl items-center justify-between px-5 py-5 sm:px-8">
        <a href="/" class="flex items-center gap-2.5"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-700 text-sm font-bold text-white">B</span><span class="text-base font-semibold tracking-tight">Bonnetje Bij</span></a>
        <nav class="flex items-center gap-3">@auth<a href="{{ route('dashboard') }}" class="rounded-xl bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Go to overview</a>@else<a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-slate-600 hover:text-slate-900">Log in</a><a href="{{ route('register') }}" class="rounded-xl bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">Get started</a>@endauth</nav>
    </header>
    <main class="mx-auto grid max-w-7xl items-center gap-14 px-5 pb-20 pt-12 sm:px-8 lg:grid-cols-[1.02fr_.98fr] lg:gap-20 lg:pb-28 lg:pt-20">
        <div class="max-w-xl">
            <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800"><span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span> A calmer way to keep track</span>
            <h1 class="mt-6 text-5xl font-semibold leading-[1.08] tracking-tight text-slate-950 sm:text-6xl">Know where your money <span class="text-emerald-700">goes.</span></h1>
            <p class="mt-6 max-w-lg text-lg leading-8 text-slate-600">A simple place for everyday spending. Log expenses, spot patterns, and make more room for what matters.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                @auth<a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">Open your overview <span aria-hidden="true">→</span></a>@else<a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800">Start tracking for free <span aria-hidden="true">→</span></a><a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">I already have an account</a>@endauth
            </div>
            <div class="mt-9 flex items-center gap-3 text-sm text-slate-500"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-emerald-800">✓</span> Your expenses stay private to your account</div>
        </div>
        <div class="relative mx-auto w-full max-w-xl">
            <div class="absolute -right-5 -top-6 h-32 w-32 rounded-full bg-lime-200/70 blur-3xl"></div><div class="absolute -bottom-8 -left-6 h-40 w-40 rounded-full bg-emerald-200/70 blur-3xl"></div>
            <div class="relative rotate-[1deg] rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-[0_24px_80px_-24px_rgba(15,23,42,.22)] sm:p-7">
                <div class="flex items-center justify-between"><div><p class="text-xs font-medium text-slate-500">Total spent this month</p><p class="mt-1 text-3xl font-semibold tracking-tight">€1,284<span class="text-xl">.50</span></p></div><span class="rounded-xl bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-800">This month</span></div>
                <div class="mt-6 flex h-36 items-end gap-3 border-b border-slate-100 pb-5 sm:gap-4">@foreach ([42, 60, 48, 80, 57, 92] as $height)<div class="flex h-full flex-1 items-end"><div class="w-full rounded-t-lg {{ $loop->last ? 'bg-emerald-700' : 'bg-emerald-200' }}" style="height: {{ $height }}%"></div></div>@endforeach</div>
                <div class="mt-2 flex justify-between px-1 text-[10px] font-medium text-slate-400"><span>May</span><span>Jun</span><span>Jul</span><span>Aug</span><span>Sep</span><span>Oct</span></div>
                <div class="mt-7 flex items-center justify-between"><div><p class="font-semibold">Recent expenses</p><p class="mt-0.5 text-xs text-slate-400">A clear view of the little things</p></div><span class="text-xs font-medium text-emerald-700">View all →</span></div>
                <div class="mt-4 divide-y divide-slate-100">
                    <div class="flex items-center gap-3 py-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-lg">☕</span><div class="min-w-0 flex-1"><p class="text-sm font-semibold">Coffee & breakfast</p><p class="text-xs text-slate-400">Food & drink · Today</p></div><span class="text-sm font-semibold">€8.40</span></div>
                    <div class="flex items-center gap-3 py-3"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-50 text-lg">🚲</span><div class="min-w-0 flex-1"><p class="text-sm font-semibold">Train to work</p><p class="text-xs text-slate-400">Transport · Yesterday</p></div><span class="text-sm font-semibold">€4.20</span></div>
                </div>
            </div>
            <div class="absolute -bottom-5 -left-5 hidden items-center gap-3 rounded-2xl border border-slate-100 bg-white px-4 py-3 shadow-lg sm:flex"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-lime-100 text-lg">✦</span><div><p class="text-xs font-semibold">Small steps add up</p><p class="text-[11px] text-slate-400">Your month at a glance</p></div></div>
        </div>
    </main>
    <footer class="mx-auto flex max-w-7xl flex-col gap-2 border-t border-slate-200 px-5 py-6 text-xs text-slate-400 sm:flex-row sm:justify-between sm:px-8"><span>Bonnetje Bij — thoughtful spending, one day at a time.</span><span>Private by design. Simple by nature.</span></footer>
</body>
</html>
