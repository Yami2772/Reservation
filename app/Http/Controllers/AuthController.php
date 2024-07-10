<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\select;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $User = User::create($request
            ->merge(["password" => Hash::make($request->password)])
            ->toArray());

        return response()->json($User);
    }

    public function login(Request $request)
    {
        $type = $request->type;
        $User = User::select('id', 'phone_number', 'password')
            ->where('phone_number', $request->phone_number)
            ->first();
        if (!$User) {
            return response()->json('User not found!');
        }

        if ($type == 'with_password') {
            if (!Hash::check($request->password, $User->password)) {
                return response()->json('Password is INCORRECT!');
            } else {
                $Token = $User->createToken($request->phone_number)->plainTextToken;
            }
            return response()->json("Token = $Token");
        }
        if ($type == 'code_request') {

            $code = rand(1000, 9999);
            $data = Code::create($request
                ->merge(["code" => $code])
                ->toArray());

            return response()->json(["code" => $data]);
        }
        if ($type == 'code_confirm') {
            $code = Code::select('phone_number', 'code')
                ->where('phone_number', $request->phone_number)
                ->first();
            if ($code['code'] == $request->code) {
                $Token = $User->createToken($request->phone_number)->plainTextToken;
                Code::where('code', $request->code)->delete();

                return response()->json("Token = $Token");
            } else {
                return response()->json('Code or phone number is INCORRECT');
            }
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json('User loggedout seccessfully!');
    }
}
