<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $User = User::where('id', $id)->first();
        }

        return response()->json($User);
    }

    public function edit(Request $request, $id)
    {
        $User = User::where('id', $id)
            ->update($request
                ->merge(["Password" => Hash::make($request->Password)])
                ->toArray());

        return response()->json($User);
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();

        return response()->json('User deleted successfully!');
    }
}
