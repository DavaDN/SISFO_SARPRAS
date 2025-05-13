<?php

namespace App\Http\Controllers\Api;

use App\Models\Pengguna; // ⬅ harus pakai ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $pengguna = Pengguna::where('email', $request->email)->first();
        if (! $pengguna || ! Hash::check($request->password, $pengguna->password)) {
            return response()->json(['message' => 'Login gagal'], 401);
        }

        $token = $pengguna->createToken('mobile')->plainTextToken;
        return response()->json(['token' => $token, 'pengguna' => $pengguna]);
    }

    public function logout(Request $request)
    {
        $request->pengguna()->tokens()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
