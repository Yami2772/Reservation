<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($request->user()->hasRole('Admin')) {
            if ($id) {
                $User = User::where('id', $id)->first();
            } else {
                $User = User::paginate(10);
            }
            return response()->json($User);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function edit(Request $request, $id)
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

    public function profileUpload(Request $request)
    {
        if ($request->user()->hasRole('User')) {
            $user = Auth::user();
            User::find($user['id'])->addMediaFromRequest()->toMediaCollection('Avatars');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
