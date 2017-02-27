<?php

namespace Laravue2\Http\Controllers;

use Laravue2\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email'
        ]);
        $user =  User::create([
            'username' => $request->input('username'),
            'email'     => $request->input('email')
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'username' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::find($id);

        $user->update($request->all());

        return response()->json([
            'message' => 'User updated successfully'
        ]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return response()->json([
            'message' => 'User delete successfully'
        ]);

    }
}
