<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
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

    public function reservationStatus($service_id, $from)
    {
        $from = Carbon::parse($from)->format('Y-m-d');
        $dates = [];
        for ($x = 0; $x < 7; $x++) {
            array_push($dates, Carbon::parse($from)->addDays($x)->format('Y-m-d'));
        }
    }
}
