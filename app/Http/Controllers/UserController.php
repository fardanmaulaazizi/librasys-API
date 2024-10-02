<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role'])->paginate(10);
        return response()->json([
            'status' => true,
            'message' => 'user retrieval successful',
            'data' => $users
        ]);
    }

    public function register(Request $request)
    {
        if ($request->user()->role_id == 2 && ($request->role_id == 1 || $request->role_id == 2)) {
            return response()->json([
                'status' => false,
                'message' => 'the librarian cannot add the Head of Library and other librarians',
            ]);
        }

        $dataUser = new User();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'massage' => 'registration failed',
                'data' => $validator->errors()
            ], 401);
        }

        $dataUser->name = $request->name;
        $dataUser->email = $request->email;
        $dataUser->password = Hash::make($request->password);
        $dataUser->role_id = $request->role_id;
        $dataUser->save();

        return response()->json([
            'status' => true,
            'massage' => 'registration successful',
            'data' => $dataUser
        ], 200);
    }

    public function update(Request $request, User $user)
    {
        if ($request->user()->role_id == 2 && $request->role_id == 1) {
            return response()->json([
                'status' => false,
                'message' => 'the librarian cannot change the user data to head of library',
            ]);
        }

        if ($request->user()->role_id == 1 && $user->role_id == 1 && $request->role_id == 2) {
            return response()->json([
                'status' => false,
                'message' => 'the lead of library cannot change their data to librarian.',
            ]);
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'massage' => 'user data update failed',
                'data' => $validator->errors()
            ], 401);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->save();
        return response()->json([
            'status' => true,
            'massage' => 'user data update successful',
            'data' => $user
        ], 200);
    }

    public function destroy(Request $request, User $user)
    {
        if (($request->user()->role_id == 2 && ($user->role_id == 1 || $user->role_id == 2)) || ($request->user()->id == $user->id)) {
            return redirect()->route('login');
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'user data deletion successful',
            'data' => $user
        ], 200);
    }
}
