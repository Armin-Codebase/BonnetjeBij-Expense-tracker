<x-app-layout>
    <div class="min-h-[calc(100vh-4rem)] bg-[#f7f8f5] px-4 py-10 sm:px-6">
        <div class="mx-auto max-w-2xl">
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-900">← Back to overview</a>
            <div class="mt-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <p class="text-sm font-medium text-emerald-700">Keep track as you go</p>
                <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Add an expense</h1>
                <p class="mt-2 text-sm text-slate-500">A few details are all you need.</p>
                @include('expenses.form', ['expense' => null, 'submitLabel' => 'Save expense', 'action' => route('expenses.store'), 'method' => 'POST'])
            </div>
        </div>
    </div>
</x-app-layout>
