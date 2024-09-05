<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckReservationsRequest;
use App\Http\Requests\CreateAndUpdateReservationRequest;
use App\Http\Requests\DeleteRequest;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Timing;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function create(CreateAndUpdateReservationRequest $request)
    {
        $Reservation = Reservation::create($request->toArray());

        return response()->json($Reservation);
    }

    public function read(Request $request, $id = null)
    {
        if ($request->user()->hasRole('Admin')) {
            if ($id) {
                $Reservation = Reservation::where('id', $id)->first();
            } else {
                $Reservation = Reservation::paginate(5)->orderBy('id', 'desc');
            }
            return response()->json($Reservation);
        } elseif ($request->user()->hasRole('User')) {
            $User = Auth::user();
            $Reservation = Reservation::where('user_id', $User['id'])->first();
            return response()->json($Reservation);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function update(CreateAndUpdateReservationRequest $request, $id)
    {
        if ($request->user()->hasRole(['Admin', 'User'])) {
            $Reservation = Reservation::where('id', $id)->first();
            if (!$Reservation) {
                return response()->json('Reservation not found!');
            } else {
                $Reservation->update($request->toArray());
            }
            return response()->json($Reservation);
        } else {
            return response()->json('You do not have the permission to access this part!');
        }
    }

    public function delete(DeleteRequest $request)
    {
        if ($request->user()->hasRole('Admin')) {
            $Reservation = Reservation::where('id', $request->id)->first();
            if ($Reservation) {
                $Reservation->delete();
                return response()->json('Reservation deleted successfully!');
            } else {
                return response()->json('Reservation not found!');
            }
        }
    }

    public function checkReservationsOfWeek(CheckReservationsRequest $request)
    {
        $from = $request->from;
        $from = Carbon::parse($from);
        $service_id = $request->service_id;
        $service = Service::find($service_id);
        if (!$service) {
            return response()->json('service_id not found', 404);
        }
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

    public function checkReservationOfMonth(Request $request)
    {
        $from = $request->from;
        $from = Carbon::parse($from);
        $timing_id = $request->timing_id;
        $timing = Timing::find($timing_id);
        if (!$timing) {
            return response()->json('Timing not found', 404);
        }
        $service_id = $request->service_id;
        $service = Service::find($service_id);
        if (!$service) {
            return response()->json('service_id not found', 404);
        }
        $ReservationStatus = [];
        for ($x = 0; $x < 30; $x++) {
            $date = $from->copy()->addDays($x)->format('Y-m-d');
            $reservations = Reservation::where('service_id', $service->id) //could have used $service['id'] too
                ->where('timing_id', $timing->id) //could have used $timing['id'] too
                ->whereDate('date', $date)
                ->exists();
            $ReservationStatus[$date] = $reservations;
        }
        return response()->json($ReservationStatus);
    }
}
