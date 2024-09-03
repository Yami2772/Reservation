<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserRequest;
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
    }

    public function edit(CreateUserRequest $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $User = User::where('id', $id)->first();
            if (!$User) {
                return response()->json('User not found!');
            } else {
                $User->update($request
                    ->merge(["Password" => Hash::make($request->Password)])
                    ->toArray());
            }
            return response()->json('User edited successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function delete(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $User = User::where('id', $id)->first();
            if ($User) {
                $User->delete();
                return response()->json('User deleted successfully!');
            } else {
                return response()->json('User not found!');
            }
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
