<form method="POST" action="{{ $action }}" class="mt-7 space-y-5">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div>
        <label for="title" class="block text-sm font-medium text-slate-700">What did you spend on?</label>
        <input id="title" name="title" type="text" maxlength="120" required autofocus value="{{ old('title', $expense?->title) }}" placeholder="e.g. Weekly groceries" class="mt-1.5 block w-full rounded-xl border-slate-200 text-sm shadow-sm placeholder:text-slate-400 focus:border-emerald-600 focus:ring-emerald-600">
        @error('title')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="amount" class="block text-sm font-medium text-slate-700">Amount (€)</label>
            <div class="relative mt-1.5"><span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">€</span><input id="amount" name="amount" type="number" min="0.01" step="0.01" max="99999999.99" required value="{{ old('amount', $expense?->amount) }}" placeholder="0.00" class="block w-full rounded-xl border-slate-200 pl-8 text-sm shadow-sm placeholder:text-slate-400 focus:border-emerald-600 focus:ring-emerald-600"></div>
            @error('amount')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="spent_at" class="block text-sm font-medium text-slate-700">Date</label>
            <input id="spent_at" name="spent_at" type="date" max="{{ now()->toDateString() }}" required value="{{ old('spent_at', $expense?->spent_at?->format('Y-m-d') ?? now()->toDateString()) }}" class="mt-1.5 block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            @error('spent_at')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
        </div>
    </div>
    <div>
        <label for="category" class="block text-sm font-medium text-slate-700">Category</label>
        <select id="category" name="category" required class="mt-1.5 block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-emerald-600 focus:ring-emerald-600">
            <option value="" disabled @selected(old('category', $expense?->category) === null)>Choose a category</option>
            @foreach ($categories as $category)<option value="{{ $category }}" @selected(old('category', $expense?->category) === $category)>{{ $category }}</option>@endforeach
        </select>
        @error('category')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="notes" class="block text-sm font-medium text-slate-700">Note <span class="font-normal text-slate-400">(optional)</span></label>
        <textarea id="notes" name="notes" rows="3" maxlength="1000" placeholder="Add a little context..." class="mt-1.5 block w-full rounded-xl border-slate-200 text-sm shadow-sm placeholder:text-slate-400 focus:border-emerald-600 focus:ring-emerald-600">{{ old('notes', $expense?->notes) }}</textarea>
        @error('notes')<p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('dashboard') }}" class="inline-flex justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancel</a>
        <button type="submit" class="inline-flex justify-center rounded-xl bg-emerald-700 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">{{ $submitLabel }}</button>
    </div>
</form>
