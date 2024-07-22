<?php

namespace App\Http\Controllers;

use App\Models\Reservstion;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $Reservation = Reservstion::create($request->merge([])->toArray());

        return response()->json($Reservation);
    }

    public function read($id = null)
    {
        if ($id) {
            $Reservation = Reservstion::where('id', $id)->first();
        } else {
            $Reservation = Reservstion::paginate(5);
        }

        return response()->json($Reservation);
    }

    public function update(Request $request, $id)
    {
        $Reservation = Reservstion::where('id', $id)->update($request->toArray());

        return response()->json($Reservation);
    }

    public function delete ($id){
        Reservstion::where('id' , $id)->delete();

        return response()->json('Reservation deleted successfully!');
    }
}
