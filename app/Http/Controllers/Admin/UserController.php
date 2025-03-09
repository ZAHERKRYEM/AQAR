<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
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

    public function store(StoreUserRequest $request)
    {
       
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_verified'=>true,
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

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

       
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
