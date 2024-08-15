<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $Service = Service::create($request->toArray());
            $Service->timings()->attach($request->timing_ids);

            return response()->json($Service);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
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
        if ($request->user()->hasRole('Admin')) {
            $Service = Service::where('id', $id)->first();
            if (!$Service) {
                return response()->json('Service not found!');
            } else {
                $Service->update($request->toArray());
                $Service->timings()->attach($request->timing_ids);
            }
            return response()->json($Service);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        if ($request->user()->hasRole('Admin')) {
            $Service = Service::where('id', $id)->first();
            if ($Service) {
                $Service->delete();
                return response()->json('Service deleted successfully!');
            } else {
                return response()->json('Service not found!');
            }
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }
}
