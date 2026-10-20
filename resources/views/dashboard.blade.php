<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-[#f7f8f5] px-4 py-8 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl space-y-7">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Your money, in perspective</p>
                    <h1 class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ Auth::user()->name }}</h1>
                    <p class="mt-2 text-sm text-slate-500">Here’s how your spending is shaping up.</p>
                </div>
                <a href="{{ route('expenses.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                    <span class="text-lg leading-none">+</span> Add expense
                </a>
            </div>

            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800" role="status">{{ session('success') }}</div>
            @endif

            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Month
                    <input type="month" name="month" value="{{ request('month', now()->format('Y-m')) }}" class="mt-1 block rounded-lg border-slate-200 text-sm text-slate-700 focus:border-emerald-600 focus:ring-emerald-600">
                </label>
                <label class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Category
                    <select name="category" class="mt-1 block rounded-lg border-slate-200 text-sm text-slate-700 focus:border-emerald-600 focus:ring-emerald-600">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="min-w-48 flex-1 text-xs font-semibold uppercase tracking-wide text-slate-500">Search
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Find an expense..." class="mt-1 block w-full rounded-lg border-slate-200 text-sm text-slate-700 placeholder:text-slate-400 focus:border-emerald-600 focus:ring-emerald-600">
                </label>
                <button class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">Apply filters</button>
                @if (request()->hasAny(['category', 'search', 'month']) && (request('category') || request('search') || request('month') !== now()->format('Y-m')))
                    <a href="{{ route('dashboard') }}" class="px-2 py-2.5 text-sm font-medium text-slate-500 hover:text-slate-900">Clear</a>
                @endif
            </form>

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Monthly overview">
                <div class="rounded-2xl bg-[#153d32] p-5 text-white shadow-sm sm:col-span-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-100/80">Total spent in {{ $month->format('F') }}</p>
                            <p class="mt-3 text-4xl font-semibold tracking-tight">€{{ number_format((float) $monthTotal, 2, ',', '.') }}</p>
                        </div>
                        <span class="rounded-xl bg-white/10 p-3 text-xl" aria-hidden="true">↗</span>
                    </div>
                    <p class="mt-6 text-sm text-emerald-100/75">{{ $expenseCount }} {{ \Illuminate\Support\Str::plural('transaction', $expenseCount) }} recorded</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Daily average</p>
                    <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">€{{ number_format((float) $dailyAverage, 2, ',', '.') }}</p>
                    <p class="mt-2 text-xs text-slate-400">Based on days elapsed this month</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Top category</p>
                    <p class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">{{ $categoryTotals->first()->category ?? '—' }}</p>
                    <p class="mt-2 text-xs text-slate-400">{{ $categoryTotals->first() ? '€'.number_format((float) $categoryTotals->first()->total, 2, ',', '.') . ' this month' : 'Add an expense to get started' }}</p>
                </div>
            </section>

            <section class="grid gap-5 lg:grid-cols-[1.4fr_1fr]">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <div class="flex items-start justify-between">
                        <div><h2 class="font-semibold text-slate-900">Spending over time</h2><p class="mt-1 text-sm text-slate-500">Your last six months</p></div>
                        <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">Monthly</span>
                    </div>
                    <div class="mt-8 flex h-44 items-end gap-3 sm:gap-5">
                        @foreach ($chartMonths as $chartMonth)
                            @php($height = $chartMonth['total'] > 0 ? max(8, (int) round($chartMonth['total'] / $chartMax * 100)) : 4)
                            <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                                <span class="text-[11px] font-medium text-slate-500">{{ $chartMonth['total'] > 0 ? '€'.number_format($chartMonth['total'], 0, ',', '.') : '' }}</span>
                                <div class="w-full max-w-14 rounded-t-lg bg-emerald-600/90 transition-all hover:bg-emerald-700" style="height: {{ $height }}%" title="{{ $chartMonth['label'] }}: €{{ number_format($chartMonth['total'], 2, ',', '.') }}"></div>
                                <span class="text-xs font-medium text-slate-400">{{ $chartMonth['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                    <h2 class="font-semibold text-slate-900">Where it goes</h2>
                    <p class="mt-1 text-sm text-slate-500">Category breakdown for {{ $month->format('F') }}</p>
                    @if ($categoryTotals->isEmpty())
                        <div class="mt-8 rounded-xl bg-slate-50 px-4 py-7 text-center text-sm text-slate-500">Your category breakdown will appear here.</div>
                    @else
                        <div class="mt-6 space-y-4">
                            @foreach ($categoryTotals->take(5) as $item)
                                @php($share = $monthTotal > 0 ? round($item->total / $monthTotal * 100) : 0)
                                <div>
                                    <div class="mb-2 flex justify-between text-sm"><span class="font-medium text-slate-700">{{ $item->category }}</span><span class="text-slate-500">€{{ number_format((float) $item->total, 2, ',', '.') }}</span></div>
                                    <div class="h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-emerald-600" style="width: {{ $share }}%"></div></div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col justify-between gap-2 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:px-6">
                    <div><h2 class="font-semibold text-slate-900">Recent expenses</h2><p class="mt-1 text-sm text-slate-500">{{ $month->format('F Y') }} activity</p></div>
                    <span class="text-sm text-slate-400">{{ $expenses->total() }} {{ \Illuminate\Support\Str::plural('result', $expenses->total()) }}</span>
                </div>
                @if ($expenses->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl text-emerald-800">＋</div>
                        <h3 class="mt-4 font-semibold text-slate-900">Nothing recorded yet</h3>
                        <p class="mx-auto mt-1 max-w-sm text-sm text-slate-500">Add your first expense to see your spending habits take shape.</p>
                        <a href="{{ route('expenses.create') }}" class="mt-5 inline-flex rounded-lg bg-emerald-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-emerald-800">Add your first expense</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[650px] text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-400"><tr><th class="px-6 py-3 font-semibold">Expense</th><th class="px-6 py-3 font-semibold">Category</th><th class="px-6 py-3 font-semibold">Date</th><th class="px-6 py-3 text-right font-semibold">Amount</th><th class="px-6 py-3"><span class="sr-only">Actions</span></th></tr></thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($expenses as $expense)
                                    <tr class="hover:bg-slate-50/70">
                                        <td class="px-6 py-4"><div class="font-semibold text-slate-800">{{ $expense->title }}</div>@if ($expense->notes)<div class="mt-0.5 max-w-xs truncate text-xs text-slate-400">{{ $expense->notes }}</div>@endif</td>
                                        <td class="px-6 py-4"><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">{{ $expense->category }}</span></td>
                                        <td class="whitespace-nowrap px-6 py-4 text-slate-500">{{ $expense->spent_at->format('d M Y') }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-slate-900">€{{ number_format((float) $expense->amount, 2, ',', '.') }}</td>
                                        <td class="px-6 py-4"><div class="flex items-center justify-end gap-3"><a href="{{ route('expenses.edit', $expense) }}" class="font-medium text-emerald-700 hover:text-emerald-900">Edit</a><form method="POST" action="{{ route('expenses.destroy', $expense) }}" onsubmit="return confirm('Delete this expense?')">@csrf @method('DELETE')<button class="font-medium text-slate-400 hover:text-rose-600">Delete</button></form></div></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if ($expenses->hasPages())<div class="border-t border-slate-100 px-6 py-4">{{ $expenses->links() }}</div>@endif
                @endif
            </section>
            <p class="pb-2 text-center text-xs text-slate-400">A little clarity goes a long way.</p>
        </div>
    </div>
</x-app-layout>
