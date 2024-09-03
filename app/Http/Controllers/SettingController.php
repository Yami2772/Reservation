<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $Setting = Setting::create($request->toArray());
            return response()->json($Setting);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function read(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $key = $request->key;
            if ($key) {
                $Setting = Setting::where('key', $key)->first();
            } else {
                $Setting = Setting::paginate(5);
            }
            return response()->json($Setting);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function update(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $key = $request->key;
            $Setting = Setting::where('key', $key);
            if (!$Setting) {
                return response()->json('Setting not found!');
            } else {
                $Setting->update($request->toArray());
            }
            return response()->json($Setting);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function delete(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $key = $request->key;
            $Setting = Setting::where('key', $key)->first();
            if ($Setting) {
                $Setting->delete();
                return response()->json('Setting deleted successfully!');
            } else {
                return response()->json('Setting not found!');
            }
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
