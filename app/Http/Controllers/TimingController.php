<?php

namespace App\Http\Controllers;

use App\Models\Timing;
use Illuminate\Http\Request;

class TimingController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $timing = Timing::create($request->toArray());
            return response()->json($timing);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function read(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $timing = Timing::get();
            return response()->json($timing);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->hasRole('Admin')) {
            $timing = Timing::where('id', $id);
            if (!$timing) {
                return response()->json('Timing not found!');
            } else {
                $timing->update($request->toArray());
            }
            return response()->json('Timing updated successfully!');
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
