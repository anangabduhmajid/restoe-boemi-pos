<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::with('roles')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('owner.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('owner.users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['cashier', 'kitchen', 'customer'])],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'is_active' => true,
        ]);

        $user->assignRole($validated['role']);

        return redirect()
            ->route('owner.users.index')
            ->with('success', "Akun '{$user->name}' berhasil disimpan.");
    }

    public function edit(User $user): View
    {
        if ($user->hasRole('owner')) {
            abort(403, 'Akun Owner tidak dapat diedit melalui menu ini.');
        }

        return view('owner.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        if ($user->hasRole('owner')) {
            abort(403, 'Akun Owner tidak dapat diedit melalui menu ini.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['cashier', 'kitchen', 'customer'])],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();
        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('owner.users.index')
            ->with('success', "Akun '{$user->name}' berhasil disimpan.");
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun sendiri.');
        }

        if ($user->hasRole('owner')) {
            return back()->with('error', 'Status akun Owner tidak dapat diubah dari sini.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $message = $user->is_active
            ? "Akun '{$user->name}' berhasil diaktifkan."
            : "Akun '{$user->name}' berhasil dinonaktifkan.";

        return back()->with('success', $message);
    }
}
