<?php

namespace App\Http\Controllers;

use App\Models\Timing;
use Illuminate\Http\Request;

class TimingController extends Controller
{
    public function create(Request $request)
    {
        $timing = Timing::create($request->toArray());

        return response()->json($timing);
    }

    public function read()
    {
        $timing = Timing::get();

        return response()->json($timing);
    }

    public function update(Request $request, $id)
    {
        $timing = Timing::where('id', $id);
        if (!$timing) {
            return response()->json('Timing not found!');
        } else {
            $timing->update($request->toArray());
        }

        return response()->json($timing);
    }

    public function delete($id)
    {
        $timing = Timing::where('id', $id);
        if ($timing) {
            $timing->delete();
            return response()->json('Timing deleted successfully!');
        } else {
            return response()->json('Timing not found!');
        }
    }
}
