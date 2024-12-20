<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AdminTeamController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->orderBy('name');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }

        $users = $query->withCount('articles')->paginate(10)->withQueryString();

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

        // Validate the request
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'editor', 'user'])],
            'is_active' => ['nullable', 'boolean'],
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Prepare update data
            $updateData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role' => $validated['role'],
                'is_active' => $request->boolean('is_active', false),
            ];

            // Only update password if provided
            if (!empty($validated['password'])) {
                $updateData['password'] = Hash::make($validated['password']);
            }

            // Update user
            $user->update($updateData);

            // Commit the transaction
            DB::commit();

            return redirect()
                ->route('admin.teams.index')
                ->with('success', 'Team member updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();
            
            return back()
                ->with('error', 'Failed to update team member: ' . $e->getMessage())
                ->withInput();
        }
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
