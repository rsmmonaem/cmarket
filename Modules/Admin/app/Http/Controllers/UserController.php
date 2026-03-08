<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(20);
        return view('admin::users.index', compact('users'));
    }

    public function create()
    {
        return view('admin::users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone|regex:/^01[0-9]{9}$/',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'status' => 'required|in:free,wallet_verified,merchant,rider,bp,me,bc,upazila,district,division,director,suspended',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
        ]);

        $user->assignRole($request->role);

        // Create main wallet
        Wallet::create([
            'user_id' => $user->id,
            'wallet_type' => 'main',
            'is_locked' => false,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('wallets', 'orders', 'kyc', 'designations');
        return view('admin::users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin::users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^01[0-9]{9}$/|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'status' => 'required|in:free,wallet_verified,merchant,rider,bp,me,bc,upazila,district,division,director,suspended',
        ]);

        $user->update($request->only(['name', 'phone', 'email', 'status']));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function generations(User $user, \App\Services\RankService $rankService)
    {
        $generations = $rankService->getGenerations($user);
        return view('admin::users.generations', compact('user', 'generations'));
    }
}
