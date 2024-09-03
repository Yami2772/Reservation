<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    public function avatarUpload(Request $request)
    {
        if ($request->user()->hasRole('User')) {
            $user = Auth::user();
            User::find($user['id'])
                ->addMediaFromRequest('avatar')
                ->usingFileName("$user->full_name.png")
                ->toMediaCollection('Avatars');
            return response()->json('avatar set successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function serviceImageUpload(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Service::where('id', $request->service_id)
                ->addMediaFromRequest('service_img')
                ->toMediaCollection('Services');
            return response()->json('IMG set successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function mainPageImage(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Setting::where('key', $request->key)
                ->addMediaFromRequest('main_page_img')
                ->usingFileName('main_page_img.png')
                ->toMediaCollection('Settings');
            return response()->json('IMG set Successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function logo(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Setting::where('key', $request->key)
                ->addMediaFromRequest('logo')
                ->usingFileName('logo.png')
                ->toMediaCollection('Settings');
            return response()->json('IMG set successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function aboutUsHeaderImage(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Setting::where('key', $request->key)
                ->addMediaFromRequest('about_us_header')
                ->usingFileName('about_us_header.png')
                ->toMediaCollection('Settings');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function aboutUsMiddleImage(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Setting::where('key', $request->key)
                ->addMediaFromRequest('about_us_middle')
                ->usingFileName('about_us_middle.png')
                ->toMediaCollection('Settings');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function aboutUsFooterImage(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            Setting::where('key', $request->key)
                ->addMediaFromRequest('about_us_footer')
                ->usingFileName('about_us_footer.png')
                ->toMediaCollection('Settings');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
