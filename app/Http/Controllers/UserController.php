<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivatingClubMembership;
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
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }

    public function edit(EditUserRequest $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $User = User::where('id', $id)->first();
            if (!$User) {
                return response()->json('User not found!', 404);
            } else {
                $User->update($request
                    ->merge(["Password" => Hash::make($request->Password)])
                    ->toArray());
            }
            return response()->json('User edited successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
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
                return response()->json('User not found!', 404);
            }
        } elseif ($request->user()->hasRole('User')) {
            $user = Auth::user();
            User::where('id', $user->id)->delete();
            return response()->json('User deleted successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }

    public function activatingClubMembership(ActivatingClubMembership $request)
    {
        if ($request->user()->hasRole('User')) {
            User::select('club_membership')
                ->where('phone_number', $request->phone_number)
                ->update($request->merge(["club_membership" => true]));
            return response()->json('club membership column set ture!');
        } else {
            return response()->json('You do not have the permission to access this part!', 403);
        }
    }

    public function banningUser(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $user = User::where('id', $request->id)->first();
            if ($user) {
                $user->update($request->merge([
                    "full_name"=> $user['full_name'],
                    "phone_number" => $user['phone_number'],
                    "national_code" => $user['national_code'],
                    "club_membership" => $user['club_membership'],
                    "birth_date" => $user['birth_date'],
                    "password" => $user['password'],
                    "sex" => $user['sex'],
                    "ban_status" => true
                ]));
            }
        }
    }
}
