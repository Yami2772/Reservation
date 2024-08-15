<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckReservationsRequest;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Timing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Monolog\Handler\WhatFailureGroupHandler;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        $Reservation = Reservation::create($request->toArray());
        return response()->json($Reservation);
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

    public function checkReservations(CheckReservationsRequest $request)
    {
        $from = $request->from;
        $from = Carbon::parse($from);
        $service_id = $request->service_id;
        $service = Service::findOrFail($service_id);
        $timings = $service->timings()->pluck('id')->toArray();
        $ReservationStatus = [];

        for ($x = 0; $x < 7; $x++) {
            $date = $from->copy()->addDays($x)->format('Y-m-d');

            foreach ($timings as $time) {
                $reservations = Reservation::where('service_id', $service_id)
                    ->whereDate('date', $date)
                    ->where('timing_id', $time)
                    ->exists();

                $ReservationStatus[$date][$time] = $reservations;
            }
        }
        return response()->json($ReservationStatus);
    }
}
