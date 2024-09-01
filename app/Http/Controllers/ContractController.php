<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRequest;
use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function create(Request $request)
    {
        if ($request->user()->hasRole(['Amin', 'User'])) {
            $Contract = Contract::create($request->toArray());
            return response()->json($Contract);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function read(Request $request, $id = null)
    {
        if ($request->user()->hasRole('Admin')) {
            if ($id) {
                $Contract = Contract::where('id', $id)->first();
            } else {
                $Contract = Contract::paginate(5)->orderBy('id','desc');
            }
            return response()->json($Contract);
        } elseif ($request->user()->hasRole('User')) {
            $User = Auth::user();
            $Contract = Contract::where('user_id', $User['id'])->first();
            return response()->json($Contract);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function delete(DeleteRequest $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $id = $request->id;
            $Reservation = Contract::where('id', $id)->first();
            if ($Reservation) {
                $Reservation->delete();
                return response()->json('Reservation deleted successfully!');
            } else {
                return response()->json('Reservation not found!');
            }
        }
    }
}
