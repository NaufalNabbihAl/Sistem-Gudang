<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json($user);
    }

    public function store(User $user){
        $validatedData = request()->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'required',
        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        return response()->json($user, 201);
    }

    public function update(Request $request, User $user){
        $validatedData = $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'sometimes|required|email|max:255|unique:users,email,'.$user->id,
            'password' => 'sometimes',
        ]);
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }
        $user->update($validatedData);
        return response()->json([
            'message' => 'Data berhasil diupdate',
            'user' => $user
        ],200);
    }

    public function show(User $user){
        return response()->json($user);
    }

    public function destroy(User $user){
        $user->delete();
        return response()->json([
            'message' => 'Data berhasil dihapus'
        ],200);
    }
}
