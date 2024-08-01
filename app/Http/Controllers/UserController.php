<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function read($id = null)
    {
        if ($id) {
            $User = User::where('id', $id)->first();
        }
        else{
            $User = User::orderBy('id','desc')->paginate(5);
        }

        return response()->json($User);
    }

    public function edit(CreateUserRequest $request, $id)
    {
        $User = User::where('id', $id)
            ->update($request
                ->merge(["Password" => Hash::make($request->Password)])
                ->toArray());

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
