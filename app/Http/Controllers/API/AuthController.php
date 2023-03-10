<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Termwind\Components\Hr;

class AuthController extends Controller
{
    // public varible header
    public const header = [
        'X-PARTNER-ID' => '123456',
        'X-EXTERNAL-ID' => '123456',
        'X-SIGNATURE' => '123456'
    ];

    // Registrasi
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        // create user
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            // 'password' => Hash::make($fields['password']), // ini pake library Hash
        ]);
        // buat token untuk user
        $token = $user->createToken('TokenRahasiaInix')->plainTextToken;
        $res = [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
            'code' => Response::HTTP_CREATED
        ];
        return response()->json($res, Response::HTTP_CREATED);
    }

    // Login
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        // cek email
        $user = User::where('email', $fields['email'])->first();
        // cek email dan password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'code' => Response::HTTP_UNAUTHORIZED // 401
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = $user->createToken('TokenRahasiaInix')->plainTextToken;
        $res = [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
            'code' => Response::HTTP_OK
        ];
        return response()->json($res, Response::HTTP_OK);
    }

    // detail user
    public function user()
    {
        $data = [
            'user' => auth()->user(),
            'code' => Response::HTTP_OK
        ];
        return response()->json(
            $data,
            Response::HTTP_OK
        );
    }

    // logout
    public function logout()
    {
        // revoke login token
        auth()->user()->tokens->each(function ($token) {
            $token->delete();
        });
        $data = [
            'message' => "logout berhasil",
            'code' => Response::HTTP_OK
        ];
        return response()->json(
            $data,
            Response::HTTP_OK
        );
    }
}
