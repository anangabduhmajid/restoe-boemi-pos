<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::with('category')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10);

        return view('owner.menus.index', compact('menus'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('owner.menus.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:150', 'unique:menus,name'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_available' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_available'] = $request->boolean('is_available');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')
                ->store('menus', 'public');
        }

        unset($validated['image']);

        Menu::create($validated);

        return redirect()
            ->route('owner.menus.index')
            ->with('success', "Menu '{$validated['name']}' berhasil disimpan.");
    }

    public function show(Menu $menu): View
    {
        $menu->load('category');

        return view('owner.menus.show', compact('menu'));
    }

    public function edit(Menu $menu): View
    {
        $categories = Category::orderBy('name')->get();

        return view('owner.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('menus', 'name')->ignore($menu->id),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_available' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_available'] = $request->boolean('is_available');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($menu->image_path) {
                Storage::disk('public')->delete($menu->image_path);
            }

            $validated['image_path'] = $request->file('image')
                ->store('menus', 'public');
        }

        unset($validated['image']);

        $menu->update($validated);

        return redirect()
            ->route('owner.menus.index')
            ->with('success', "Menu '{$menu->name}' berhasil disimpan.");
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        // Soft delete: data menu tetap tersimpan di database.
        $menu->delete();

        return redirect()
            ->route('owner.menus.index')
            ->with('success', "Menu '{$menu->name}' berhasil dihapus.");
    }
}
