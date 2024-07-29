<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $User = User::where('id', $id)->first();
        } else {
            $User = User::get();
        }

        return response()->json($User);
    }

    public function edit(Request $request, $id)
    {
        $User = User::where('id', $id)->first();
        if (!$User) {
            return response()->json('User not found!');
        } else {
            $User->update($request
                ->merge(["Password" => Hash::make($request->Password)])
                ->toArray());
        }

        return response()->json($User);
    }

    public function delete($id)
    {
        $User = User::where('id', $id)->first();
        if ($User) {
            $User->delete();
            return response()->json('User deleted successfully!');
        } else {
            return response()->json('User not found!');
        }
    }
}
