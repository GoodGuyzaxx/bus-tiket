<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PassengerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:passengers',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
        ]);

        $passenger = Passenger::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

//        $token = $passenger->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Akun Berhail Dibuat',
            'passenger' => $passenger,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $passenger = Passenger::where('email', $request->email)->first();

        if (!$passenger || !Hash::check($request->password, $passenger->password)) {
            return response()->json([
                'message' => "Password atau Email yang anda masukan salah",
            ]);
        }

        $token = $passenger->createToken('auth_token')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'passenger' => $passenger,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil Logout',
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }

    public function updateProfile(Request $request)
    {
        $passenger = $request->user();

        $request->validate([
            'name' => 'string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $passenger->update($request->only(['name', 'phone']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'passenger' => $passenger,
        ]);
    }
}
