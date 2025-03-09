<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Validation\ValidationException;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
       
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'user_type' => 'seller',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }

    public function verifyEmail(Request $request)
    {
    $request->validate([
        'email' => 'required|email',
        'verification_code' => 'required',
    ]);

    $user = User::where('email', $request->email)->where('verification_code', $request->verification_code)->first();

    if (!$user) {
        return response()->json([
            'message' => 'Invalid verification code.',
            'status' => 'error'
        ], 400);
    }

    $user->update([
        'is_verified' => true,
        'verification_code' => null 
    ]);

    return response()->json([
        'message' => 'Email verified successfully.',
        'status' => 'success'
    ], 200);
    }


    public function resendVerificationCode(Request $request)
    {
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = User::where('email', $request->email)->first();

    if ($user->is_verified) {
        return response()->json([
            'message' => 'This email is already verified.',
            'status' => 'error'
        ], 400);
    }

    $verification_code = mt_rand(100000, 999999);
    $user->update(['verification_code' => $verification_code]);

    Mail::to($user->email)->send(new Email($verification_code));

    return response()->json([
        'message' => 'A new verification code has been sent to your email.',
        'status' => 'success'
    ], 200);
    }

    public function login(LoginRequest $request)
    {
        
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Unauthorized',
                'status_code' => 401
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'token' => $token
                    ],
            'message' => 'Logged in successfully',
            'status_code' => 200            
            
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Logged out successfully',
            'status_code' => 200 
        ], 200);
    }
}
