<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimingRequest;
use App\Models\Service;
use App\Models\Timing;
use Illuminate\Http\Request;

class TimingController extends Controller
{
    public function create(Request $request)
    {
        $Timing = Timing::create($request->toArray());

        return response()->json($Timing);
    }
    public function read($id = null)
    {
        if ($id) {
            $timing = Timing::where('id', $id)->first();
        } else {
            $timing = Timing::paginate(5);
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
