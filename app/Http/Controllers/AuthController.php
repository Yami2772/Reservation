<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Jobs\SendCode;
use App\Models\Code;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(CreateUserRequest $request)
    {
        $User = User::create($request
            ->merge(["password" => Hash::make($request->password)])
            ->toArray());
        $User->assignRole('User');
        return response()->json($User);
    }

    public function login(LoginRequest $request)
    {
        $type = $request->type;
        $User = User::select('id', 'phone_number', 'password', 'ban_status')
            ->where('phone_number', $request->phone_number)
            ->first();
        if (!$User) {
            return response()->json('User not found!');
        } elseif ($type == 'with_password') {
            if (!Hash::check($request->password, $User->password)) {
                return response()->json('Password is INCORRECT!');
            } else {
                if (!$User->ban_status) {
                    $Token = $User->createToken($request->phone_number)->plainTextToken;
                } else {
                    return response()->json('Ur account is banned by Admin', 403);
                }
            }
            return response()->json(["Token" => $Token]);
        } elseif ($type == 'code_request') {
            Code::where('phone_number', $request->phone_number)->delete();
            $code = rand(1000, 9999);
            $expiration_time = Carbon::now()->addMinutes(5)->format('Y-m-d H:i:s');
            $data = Code::create($request
                ->merge([
                    "code" => $code,
                    "expiration_time" => $expiration_time
                ])
                ->toArray());
            SendCode::dispatch($User, $code);
            return response()->json([$data, 'code sent successfully!']);
        } elseif ($type == 'code_confirm') {
            $code = Code::select('phone_number', 'code', 'expiration_time')
                ->where('phone_number', $request->phone_number)
                ->first();
            $now = Carbon::now()->format('Y-m-d H:i:s');
            if ($code['code'] == $request->code) {
                if ($now <= $code['expiration_time']) {
                    if (!$User->ban_status) {
                        $Token = $User->createToken($request->phone_number)->plainTextToken;
                    } else {
                        return response()->json('Ur account is banned by Admin', 403);
                    }
                    Code::where('code', $request->code)->delete();
                    return response()->json(["Token" => $Token]);
                } else {
                    return response()->json('The code is EXPIRED!');
                }
            } else {
                return response()->json('Code or phone number is INCORRECT');
            }
        } else {
            return response()->json('type is incorrect!');
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json('User loggedout seccessfully!');
    }

    public function me()
    {
        $User = Auth::user();
        return response()->json($User);
    }
}
