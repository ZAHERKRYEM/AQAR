<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => User::all(),
            'message' => 'Users retrieved successfully',
            'status_code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
            'user_type' => 'string',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type ?? 'seller',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'message' => 'User created successfully',
            'status_code' => 201
        ], 201);
    }

    public function show(User $user)
    {
        return response()->json([
            'status' => 'success',
            'data' => $user,
            'message' => 'User retrieved successfully',
            'status_code' => 200
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'string',
            'email' => 'email|unique:users,email,' . $user->id,
            'phone' => 'string',
            'password' => 'nullable|string|min:6',
            'user_type' => 'string',
        ]);

        $user->update($request->only(['username', 'email', 'phone', 'user_type']));
        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'message' => 'User updated successfully',
            'status_code' => 200
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'User deleted successfully',
            'status_code' => 200
        ]);
    }
}
