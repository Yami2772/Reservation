<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAndUpdateTimingRequest;
use App\Models\Timing;
use Illuminate\Http\Request;

class TimingController extends Controller
{
    public function create(CreateAndUpdateTimingRequest $request)
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

        return response()->json('Timing updated successfully!');
    }
}
