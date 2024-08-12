<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckReservationsRequest;
use App\Models\Reservation;
use App\Models\Service;
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
        $service_id = $request->service_id;
        $from = Carbon::parse($from);
        $service = Service::findOrFail($service_id);
        $timings = $service->timings->pluck('start_time')->toArray();
        $ReservationStatus = [];

        for ($x = 0; $x < 7; $x++) {
            $date = $from->copy()->addDays($x)->format('Y-m-d');

            foreach ($timings as $time) {
                $reservations = Reservation::where('service_id', $service_id)
                    ->whereDate('date', $date)
                    ->exists();

                $ReservationStatus[$date][$time] = $reservations;
            }
        }

        return response()->json($ReservationStatus);
    }
}
