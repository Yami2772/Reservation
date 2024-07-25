<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function create(Request $request)
    {
        $Service = Service::create($request->toArray());

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
        $Service = Service::where('id', $id)->update($request->toArray());

        return response()->json($Service);
    }

    public function delete($id)
    {
        $Service = Service::where('id', $id)->first();
        if ($Service) {
            $Service->delete();
            return response()->json('User deleted successfully!');
        } else {
            return response()->json('User not found!');
        }
    }
}
