<?php

namespace App\Http\Controllers;

use App\Exports\HotelExport;
use App\Http\Resources\Hotel\HotelCollection;
use App\Http\Resources\Hotel\HotelResource;
use App\Models\Hotel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use CSV;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::all();
        if (is_null($hotels) || count($hotels) === 0) {
            return response()->json('No hotels found!', 404);
        }
        return response()->json([
            'hotels' => new HotelCollection($hotels)
        ]);
    }

    public function exportCSV()
    {
        return CSV::download(new HotelExport, 'hotels-export.csv');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        if (is_null($hotel)) {
            return response()->json('Hotel not found', 404);
        }
        return response()->json([
            'hotel' => new HotelResource($hotel)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'rating' => 'required|decimal:1|between:0,5',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hotel->name = $request->name;
        $hotel->type = $request->type;
        $hotel->city = $request->city;
        $hotel->address = $request->address;
        $hotel->rating = $request->rating;
        $hotel->description = $request->description;

        $hotel->save();

        return response()->json([
            'Hotel updated' => new HotelResource($hotel)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json('Hotel deleted');
    }
}
