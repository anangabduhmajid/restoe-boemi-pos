<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\DiningTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiningTableController extends Controller
{
    public function index()
    {
        $tables = DiningTable::orderBy('sort_order')
            ->orderBy('table_number')
            ->paginate(10);

        return view('owner.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('owner.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => ['required', 'string', 'max:20', 'unique:dining_tables,table_number'],
            'name' => ['nullable', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:255'],
            'status' => ['required', Rule::in(['available', 'occupied', 'reserved', 'maintenance'])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $table = DiningTable::create($validated);

        return redirect()
            ->route('owner.tables.index')
            ->with('success', "Meja '{$table->table_number}' berhasil disimpan.");
    }

    public function edit(DiningTable $table)
    {
        return view('owner.tables.edit', compact('table'));
    }

    public function update(Request $request, DiningTable $table)
    {
        $validated = $request->validate([
            'table_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('dining_tables', 'table_number')->ignore($table->id),
            ],
            'name' => ['nullable', 'string', 'max:100'],
            'capacity' => ['required', 'integer', 'min:1', 'max:255'],
            'status' => ['required', Rule::in(['available', 'occupied', 'reserved', 'maintenance'])],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $table->update($validated);

        return redirect()
            ->route('owner.tables.index')
            ->with('success', "Meja '{$table->table_number}' berhasil disimpan.");
    }

    public function destroy(DiningTable $table)
    {
        $table->delete();

        return redirect()
            ->route('owner.tables.index')
            ->with('success', "Meja '{$table->table_number}' berhasil dihapus.");
    }
}
