<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $selectedMonth = $request->string('month')->toString();
        $hasValidMonth = preg_match('/^(\d{4})-(\d{2})$/', $selectedMonth, $monthParts)
            && checkdate((int) $monthParts[2], 1, (int) $monthParts[1]);
        $month = $hasValidMonth
            ? CarbonImmutable::createFromFormat('!Y-m', $selectedMonth)
            : CarbonImmutable::now()->startOfMonth();
        $categories = ExpenseController::CATEGORIES;

        $baseQuery = Expense::query()
            ->where('user_id', $request->user()->id)
            ->whereBetween('spent_at', [$month->startOfMonth(), $month->endOfMonth()]);

        $monthTotal = (clone $baseQuery)->sum('amount');
        $expenseCount = (clone $baseQuery)->count();
        $dailyAverage = $monthTotal / max(1, min($month->daysInMonth, $month->isCurrentMonth() ? now()->day : $month->daysInMonth));

        $categoryTotals = (clone $baseQuery)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $expensesQuery = (clone $baseQuery)->latest('spent_at')->latest('id');
        if ($request->filled('category') && in_array($request->string('category')->toString(), $categories, true)) {
            $expensesQuery->where('category', $request->string('category')->toString());
        }
        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $expensesQuery->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $expenses = $expensesQuery->paginate(8)->withQueryString();
        $chartMonths = collect(range(5, 0))->map(function (int $offset): array {
            $date = CarbonImmutable::now()->startOfMonth()->subMonths($offset);
            $total = Expense::query()
                ->where('user_id', auth()->id())
                ->whereBetween('spent_at', [$date->startOfMonth(), $date->endOfMonth()])
                ->sum('amount');

            return ['label' => $date->format('M'), 'total' => (float) $total];
        });
        $chartMax = max(1, (float) $chartMonths->max('total'));

        return view('dashboard', compact(
            'month', 'monthTotal', 'expenseCount', 'dailyAverage', 'categoryTotals',
            'categories', 'expenses', 'chartMonths', 'chartMax'
        ));
    }
}
