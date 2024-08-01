<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create(Request $request)
    {
        $Setting = Setting::create($request->toArray());

        return response()->json($Setting);
    }

    public function read(Request $request)
    {
        $key = $request->key;
        if ($key) {
            $Setting = Setting::where('key', $key)->first();
        } else {
            $Setting = Setting::paginate(5);
        }

        return response()->json($Setting);
    }

    public function update(Request $request)
    {
        $key = $request->key;
        $Setting = Setting::where('key', $key);
        if (!$Setting) {
            return response()->json('Setting not found!');
        } else {
            $Setting->update($request->toArray());
        }

        return response()->json($Setting);
    }

    public function delete(Request $request)
    {
        $key = $request->key;
        $Setting = Setting::where('key', $key)->first();
        if ($Setting) {
            $Setting->delete();
            return response()->json('Setting deleted successfully!');
        } else {
            return response()->json('Setting not found!');
        }
    }
}
