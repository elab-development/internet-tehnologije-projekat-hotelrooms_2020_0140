<?php

namespace App\Http\Controllers;

use App\Http\Resources\Reservation\ReservationCollection;
use App\Http\Resources\Reservation\ReservationResource;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::all();
        if (is_null($reservations) || count($reservations) === 0) {
            return response()->json('No reservations found', 404);
        }
        return response()->json(new ReservationCollection($reservations));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'room_id' => 'required|integer',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('Guest not found!', 404);
        }

        $room = Room::find($request->room_id);
        if (is_null($room)) {
            return response()->json('Room not found!', 404);
        }

        if (strtotime(date('Y-m-d', strtotime($request->checkin))) > strtotime(date('Y-m-d', strtotime($request->checkout)))) {
            return response()->json('Check-in date must be before check-out date!', 403);
        }

        $reservation = Reservation::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
        ]);

        return response()->json([
            'Reservation created' => new ReservationResource($reservation)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        if (is_null($reservation)) {
            return response()->json('Reservation not found', 404);
        }
        return response()->json(new ReservationResource($reservation));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'room_id' => 'required|integer',
            'checkin' => 'required|date',
            'checkout' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::find($request->user_id);
        if (is_null($user)) {
            return response()->json('Guest not found!', 404);
        }

        $room = Room::find($request->room_id);
        if (is_null($room)) {
            return response()->json('Room not found!', 404);
        }

        if (strtotime(date('Y-m-d', strtotime($request->checkin))) > strtotime(date('Y-m-d', strtotime($request->checkout)))) {
            return response()->json('Check-in date must be before check-out date!', 403);
        }

        $reservation->user_id = $request->user_id;
        $reservation->room_id = $request->room_id;
        $reservation->checkin = $request->checkin;
        $reservation->checkout = $request->checkout;

        $reservation->save();

        return response()->json([
            'Reservation updated' => new ReservationResource($reservation)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return response()->json('Reservation removed');
    }
}
