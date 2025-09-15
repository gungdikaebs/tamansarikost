<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $reportsQuery = Report::query();

        if ($startDate && $endDate) {
            $reportsQuery->whereBetween('date', [$startDate, $endDate]);
        }

        $reports = $reportsQuery->get();

        $subtotalIncome = $reports->where('type', 'income')->sum('amount');
        $subtotalExpense = $reports->where('type', 'outcome')->sum('amount');
        $subtotalNetto = $subtotalIncome - $subtotalExpense;

        return inertia('Admin/Reports/Index', [
            'reports' => $reports,
            'filters' => ['start_date' => $startDate, 'end_date' => $endDate],
            'subtotalNetto' => $subtotalNetto,

        ]);
    }
    public function create()
    {
        return inertia('Admin/Reports/AddReport');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'nullable|integer|exists:payments,id',
            'date' => 'required|date',
            'type' => 'required|in:income,outcome',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        Report::create($validated);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $report = Report::findOrFail($id);
        return inertia('Admin/Reports/EditReport', [
            'report' => $report
        ]);
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $validated = $request->validate([
            'payment_id' => 'nullable|integer|exists:payments,id',
            'date' => 'required|date',
            'type' => 'required|in:income,outcome',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ]);

        $report->update($validated);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return Inertia::location(route('reports.index'));
    }
}
