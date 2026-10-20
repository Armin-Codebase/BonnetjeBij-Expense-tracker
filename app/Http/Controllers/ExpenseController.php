<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public const CATEGORIES = [
        'Food & drink', 'Transport', 'Shopping', 'Home', 'Bills', 'Health', 'Entertainment', 'Other',
    ];

    public function create(): View
    {
        return view('expenses.create', ['categories' => self::CATEGORIES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $request->user()->expenses()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Expense added successfully.');
    }

    public function edit(Request $request, Expense $expense): View
    {
        abort_unless($expense->user_id === $request->user()->id, 404);

        return view('expenses.edit', ['expense' => $expense, 'categories' => self::CATEGORIES]);
    }

    public function update(Request $request, Expense $expense): RedirectResponse
    {
        abort_unless($expense->user_id === $request->user()->id, 404);
        $expense->update($request->validate($this->rules()));

        return redirect()->route('dashboard')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Request $request, Expense $expense): RedirectResponse
    {
        abort_unless($expense->user_id === $request->user()->id, 404);
        $expense->delete();

        return redirect()->route('dashboard')->with('success', 'Expense deleted.');
    }

    /** @return array<string, array<int, mixed>> */
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:99999999.99'],
            'category' => ['required', 'string', 'in:'.implode(',', self::CATEGORIES)],
            'spent_at' => ['required', 'date', 'before_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
