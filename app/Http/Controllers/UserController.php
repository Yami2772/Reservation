<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Http\Requests\EditUserRequest;
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
                $User = User::paginate(10)->orderBy('id', 'desc');
            }
            return response()->json($User);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function edit(EditUserRequest $request, $id)
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

    public function delete(DeleteRequest $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $User = User::where('id', $request->id)->first();
            if ($User) {
                $User->delete();
                return response()->json('User deleted successfully!');
            } else {
                return response()->json('User not found!');
            }
        } elseif ($request->user()->hasRole('User')) {
            $user = Auth::user();
            User::where('id', $user->id)->delete();
            return response()->json('User deleted successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
