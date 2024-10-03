<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'massage' => 'login failed',
                'data' => $validator->errors()
            ], 401);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'login failed, account not found',
            ], 401);
        }

        $dataUser =
            User::with('role')->where('email', $request->email)->first();
        if ($dataUser->role_id == 1 || $dataUser->role_id == 2) {
            $token = $dataUser->createToken('authToken', ['manage-applications'])->plainTextToken;
        } else {
            $token = $dataUser->createToken('authToken', [])->plainTextToken;
        }

        return response()->json([
            'status' => true,
            'message' => 'login successful',
            'token' => $token,
            'data' => $dataUser
        ], 200);
    }
}
