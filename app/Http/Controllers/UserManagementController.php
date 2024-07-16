<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        return Inertia::render('UserManagement', [
            'initialUsers' => $users
        ]);
    }

    public function getUsers(Request $request)
    {
        if ($request->wantsJson()) {
            return User::all();
        }
        return Inertia::render('UserManagement', [
            'users' => User::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => $validated['is_admin'],
        ]);

        if ($request->wantsJson()) {
            return response()->json($user, 201);
        }
        return Inertia::render('UserManagement', [
            'users' => User::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
            'is_admin' => 'boolean',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if ($validated['password']) {
            $user->password = Hash::make($validated['password']);
        }
        $user->is_admin = $validated['is_admin'];
        $user->save();

        if ($request->wantsJson()) {
            return response()->json($user);
        }
        return Inertia::render('UserManagement', [
            'users' => User::all()
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();
        if ($request->wantsJson()) {
            return response()->json(null, 204);
        }
        return Inertia::render('UserManagement', [
            'users' => User::all()
        ]);
    }

    public function getUserReports(Request $request, User $user)
    {
        $reports = Evaluation::where('user_id', $user->id)
            ->whereNotNull('report')
            ->select('id', 'field', 'created_at')
            ->get();

        if ($request->wantsJson()) {
            return response()->json($reports);
        }
        return Inertia::render('UserManagement', [
            'userReports' => $reports
        ]);
    }
}
