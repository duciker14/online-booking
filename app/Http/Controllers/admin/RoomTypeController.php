<?php

namespace App\Http\Controllers\admin;

use App\Enums\RoomTypeStatus;
use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index() {
        $roomType = RoomType::orderBy('id', 'DESC')->paginate(10);

        return view('admin.hotels.room-type', compact('roomType'));
    }

    public function create(Request $request) {
        $request->validate([
            'roomType' => 'required'
        ]);

        RoomType::create([
            'name' => $request->roomType,
            'status' => RoomTypeStatus::ACTIVE
        ]);

        return redirect()->back()->with('message', 'Create successfully');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'roomType' => 'required'
        ]);

        $roomType = RoomType::find($id);
        $roomType->name = $request->roomType;
        $roomType->save();

        return redirect()->back()->with('message', 'Update successfully');
    }

    public function status($id) {
        $roomType = RoomType::find($id);

        if($roomType->status == RoomTypeStatus::ACTIVE) {
            $roomType->status = RoomTypeStatus::DISABLED;
        }else {
            $roomType->status = RoomTypeStatus::ACTIVE;
        }
        $roomType->save();

        return redirect()->back();
    }

    public function destroy($id) {
        RoomType::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete successfully');
    }
}
