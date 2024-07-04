<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $User = User::create($request
            ->merge(["Password" => Hash::make($request->Password)])
            ->toArray());

        return response()->json($User);
    }

    public function login(Request $request)
    {
        $type = $request->type;
        $User = User::select('id', 'MobileNumber', 'Password')
            ->where('MobileNumber', $request->MobileNumber)
            ->first();
        if (!$User) {
            return response()->json('User not found!');
        }

        if ($type == 'login') {
            if (!Hash::check($request->Password, $User->Password)) {
                return response()->json('Password is INCORRECT!');
            } else {
                $Token = $User->createToken($request->MobileNumber)->plainTextToken;
            }
            return response()->json("Token = $Token");
        }
        if ($type == 'code_request') {

            $code = rand(1000, 9999);
            $data = Auth::create($request
                ->merge(["Code" => $code])
                ->toArray());

            return response()->json(["code" => $data]);
        }
        if ($type == 'code_confirm') {
            $Code = Auth::select('code');
            if ($request->code == $Code) {
                $Token = $User->createToken($request->MobileNumber)->plainTextToken;

                return response()->json("Token = $Token");
            } else {
                return response()->json('Code is INCORRECT');
            }
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json('User loggedout seccessfully!');
    }
}
