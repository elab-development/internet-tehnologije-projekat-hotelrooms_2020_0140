<?php

namespace App\Http\Controllers;

use App\Http\Resources\Room\RoomCollection;
use App\Http\Resources\Room\RoomResource;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        if (is_null($rooms) || count($rooms) === 0) {
            return response()->json('No rooms found!', 404);
        }
        return response()->json(new RoomCollection($rooms));
    }

    public function indexPaginate()
    {
        $rooms = Room::all();
        if (is_null($rooms) || count($rooms) === 0) {
            return response()->json('No rooms found!', 404);
        }
        $rooms = Room::paginate(20);
        return response()->json(new RoomCollection($rooms));
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
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'features' => 'required|string|max:255',
            'price' => 'required|double',
            'hotel_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hotel = Hotel::find($request->hotel_id);
        if (is_null($hotel)) {
            return response()->json('Hotel not found!', 404);
        }

        $room = Room::create([
            'name' => $request->name,
            'number' => $request->number,
            'features' => $request->features,
            'price' => $request->price,
            'hotel_id' => $request->hotel_id,
        ]);

        return response()->json([
            'Room created' => new RoomResource($room)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($room_id)
    {
        $room = Room::find($room_id);
        if (is_null($room)) {
            return response()->json('Room not found', 404);
        }
        return response()->json(new RoomResource($room));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'features' => 'required|string|max:255',
            'price' => 'required|double',
            'hotel_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hotel = Hotel::find($request->hotel_id);
        if (is_null($hotel)) {
            return response()->json('Hotel not found!', 404);
        }

        $room->name = $request->name;
        $room->number = $request->number;
        $room->features = $request->features;
        $room->price = $request->price;
        $room->hotel_id = $request->hotel_id;

        $room->save();

        return response()->json([
            'Room updated' => new RoomResource($room)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return response()->json('Room removed');
    }
}
