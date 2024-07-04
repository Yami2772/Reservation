<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LogRController extends Controller
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
        $User = User::select('id', 'MobileNumber', 'Password')
            ->where('MobileNumber', $request->MobileNumber)
            ->first();
        if (!$User) {
            return response()->json('User not found!');
        }
        if (!Hash::check($request->Password, $User->Password)) {
            return response()->json('Password is INCORRECT!');
        }
        $Token = $User->createToken($request->MobileNumber)->plainTextToken;

        return response()->json("Token = $Token");
    }
}
