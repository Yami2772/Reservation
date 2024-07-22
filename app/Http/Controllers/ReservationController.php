<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create (Request $request){
        $create = Reservation::create($request->toArray());
          $create->Service()->attach($request->service_id);
        return response()->json($create);
      }

    public function read($id = null)
    {
        if ($id) {
            $Reservation = Reservation::where('id', $id)->first();
        } else {
            $Reservation = Reservation::paginate(5);
        }

        return response()->json($Reservation);
    }

    public function update(Request $request, $id)
    {
        $Reservation = Reservation::where('id', $id)->update($request->toArray());

        return response()->json($Reservation);
    }

    public function delete ($id){
        Reservation::where('id' , $id)->delete();

        return response()->json('Reservation deleted successfully!');
    }
    public function detach(Request $request, $id){
        $order = Reservation::find($id);
        $order->products()->detach($request->product_id); 
        return response()->json($order);
    }
}
