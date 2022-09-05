<?php

namespace App\Http\Controllers\admin;

use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roomStatus = RoomStatus::asArray();
        $hotels = Hotel::all();
        $roomType = RoomType::all();

        $query = Room::withSearch();

        if($request->has('hotel') && $request->hotel != 'all') {
            $query = $query->where('hotel_id', $request->hotel);
        }
        if($request->has('status') && $request->status != 'all') {
            $query = $query->where('status', $request->status);
        }
        if($request->has('type') && $request->type != 'all') {
            $query = $query->where('room_type_id', $request->type);
        }

        $rooms = $query->orderBy('id', 'DESC')->paginate(10);

        return view('admin.rooms.index', compact('rooms', 'roomStatus', 'hotels', 'roomType'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        if(count($room->bookings) < 1) {
            $room->delete();
            return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Room has bookings');
        }
    }

    public function search(Request $request)
    {
        $rooms = Room::withSearch()->searchWithStatus()->paginate(5);
        return view('admin.rooms.index', compact('rooms'));
    }
}
