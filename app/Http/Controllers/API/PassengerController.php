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
            'address' => 'nullable|string',
            'id_card_number' => 'required|string|unique:passengers',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
        ]);

        $passenger = Passenger::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'id_card_number' => $request->id_card_number,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        $token = $passenger->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Passenger registered successfully',
            'passenger' => $passenger,
            'token' => $token,
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
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
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
            'message' => 'Successfully logged out',
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
            'address' => 'nullable|string',
        ]);

        $passenger->update($request->only(['name', 'phone', 'address']));

        return response()->json([
            'message' => 'Profile updated successfully',
            'passenger' => $passenger,
        ]);
    }
}
