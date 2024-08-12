<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReservationRequest;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Monolog\Handler\WhatFailureGroupHandler;

class ReservationController extends Controller
{
    public function create (CreateReservationRequest $request){
        $create = Reservation::create($request->toArray());
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
        $Reservation = Reservation::where('id', $id)->first();
        if (!$Reservation) {
            return response()->json('Reservation not found!');
        } else {
            $Reservation->update($request->toArray());
        }

        return response()->json($Reservation);
    }

    public function delete($id)
    {
        $Reservation = Reservation::where('id', $id)->first();
        if ($Reservation) {
            $Reservation->delete();
            return response()->json('Reservation deleted successfully!');
        } else {
            return response()->json('Reservation not found!');
        }
    }

    public function checkReservations($service_id, $from)
    {
        // Create a Carbon instance for the input date
        $from = Carbon::parse($from);

        // Create an array to store the results
        $reservationsByDayAndTiming = [];

        // Loop through each day of the week
        for ($x = 0; $x < 7; $x++) {
            // Calculate the date for the current day
            $Date = $from->copy()->addDays($x);

            // Query for reservations on the requested date
            $reservations = Reservation::where('service_id', $service_id)
                ->whereDate('date', $Date->format('Y-m-d'))
                ->get();

            // Organize reservations by timing
            $timings = $reservations->groupBy('timing_id');
            $reservationsByDayAndTiming[$Date->format('Y-m-d')] = $timings;
        }

        // Return the results as JSON
        return response()->json($reservationsByDayAndTiming);
    }
}
