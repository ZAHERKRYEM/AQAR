<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropertyController;

// Middleware for Admin Access
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('properties', PropertyController::class);
});

// Middleware definition (App\Http\Middleware\AdminMiddleware.php)
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->user_type !== 'admin') {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Unauthorized',
                'status_code' => 403
            ], 403);
        }
        return $next($request);
    }
}

// Register Middleware in Kernel.php
// In App\Http\Kernel.php, add this to $routeMiddleware array:
// 'admin' => \App\Http\Middleware\AdminMiddleware::class,

// UserController.php
namespace App\Http\Controllers;

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

// PropertyController.php
namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => Property::all(),
            'message' => 'Properties retrieved successfully',
            'status_code' => 200
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'property_type' => 'required|string',
            'transaction_type' => 'required|string',
            'price' => 'required|numeric',
            'area' => 'required|numeric',
            'city' => 'required|string',
            'neighborhood' => 'required|string',
            'owner' => 'required|exists:users,id',
        ]);

        $property = Property::create($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $property,
            'message' => 'Property created successfully',
            'status_code' => 201
        ], 201);
    }

    public function show(Property $property)
    {
        return response()->json([
            'status' => 'success',
            'data' => $property,
            'message' => 'Property retrieved successfully',
            'status_code' => 200
        ]);
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'string',
            'property_type' => 'string',
            'transaction_type' => 'string',
            'price' => 'numeric',
            'area' => 'numeric',
            'city' => 'string',
            'neighborhood' => 'string',
        ]);

        $property->update($request->all());
        return response()->json([
            'status' => 'success',
            'data' => $property,
            'message' => 'Property updated successfully',
            'status_code' => 200
        ]);
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Property deleted successfully',
            'status_code' => 200
        ]);
    }
}
