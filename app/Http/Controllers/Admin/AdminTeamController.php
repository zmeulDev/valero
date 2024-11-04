<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AdminTeamController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')
            ->withCount('articles')
            ->paginate(10);
        return view('admin.teams.index', compact('users'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', Rule::in(['admin', 'editor', 'user'])],
            'is_active' => ['boolean'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);
        
        User::create($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team member created successfully.');
    }

    public function edit(User $user)
    {
        // Prevent editing super admin if you're not one
        if ($user->role === 'admin' && auth()->user()->role !== 'admin') {
            return back()->with('error', 'You cannot edit admin users.');
        }

        return view('admin.teams.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Prevent editing super admin if you're not one
        if ($user->role === 'admin' && auth()->user()->role !== 'admin') {
            return back()->with('error', 'You cannot update admin users.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', Password::defaults()],
            'role' => ['required', Rule::in(['admin', 'editor', 'user'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Set is_active based on the request
        $validated['is_active'] = $request->boolean('is_active', false);

        $user->update($validated);

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->role === 'admin' && auth()->user()->role !== 'admin') {
            return back()->with('error', 'You cannot delete admin users.');
        }

        $user->delete();

        return redirect()->route('admin.teams.index')
            ->with('success', 'Team member deleted successfully.');
    }
}
