<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function avatarUpload(Request $request)
    {
        if ($request->user()->hasRole('User')) {
            $user = Auth::user();
            User::find($user['id'])->addMediaFromRequest('avatar')->toMediaCollection('Avatars');
            return response()->json('avatar set successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function serviceImageUpload(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Service::where('id', $request->service_id)->addMediaFromRequest('service_img')->toMediaCollection('Services');
            return response()->json('IMG set successfully!');
        }else{
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
