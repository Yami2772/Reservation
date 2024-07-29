<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function create(Request $request)
    {
        $Service = Service::create($request->toArray());
        $Service->timings()->attach($request->timing_ids);

        return response()->json($Service);
    }

    public function read($id = null)
    {
        if ($id) {
            $Service = Service::where('id', $id)->first();
        } else {
            $Service = Service::paginate(5);
        }

        return response()->json($Service);
    }

    public function update(Request $request, $id)
    {
        $Service = Service::where('id', $id)->first();
        if (!$Service) {
            return response()->json('Service not found!');
        } else {
            $Service->update($request->toArray());
            $Service->timings()->attach($request->timing_ids);
        }

        return response()->json($Service);
    }

    public function delete($id)
    {
        $Service = Service::where('id', $id)->first();
        if ($Service) {
            $Service->delete();
            return response()->json('Service deleted successfully!');
        } else {
            return response()->json('Service not found!');
        }
    }
}
