<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class userController extends Controller
{
    function Login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        } else {
            $token = $user->createToken('tokenAuth')->plainTextToken;

            Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            return response()->json(['message' => 'Login Successful', 'token' => $token], 200);
        }
    }
    public function getUser(Request $request)
    {
        if ($request->user()) {
            return $request->user()->id;
        } else {
            return "error";
        }
    }

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
