<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json($users);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json($user);
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json('User deleted successfully');
    }
}
