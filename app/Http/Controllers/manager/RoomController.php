<?php

namespace App\Http\Controllers\manager;

use App\Enums\RoomTypeStatus;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $hotel = Hotel::where('user_id',$id)->first();
        $list = Room::where('hotel_id',$hotel->id)->orderByDesc('rooms.id')->get();

        $list_img = Room::select('id','img')->orderBy('id','ASC')->get();
        $json_img_room = public_path()."/img/rooms/json_file/";
        if (!is_dir($json_img_room)) {
            mkdir($json_img_room,0777,true);
        }
        File::put($json_img_room.'imgroom.json',json_encode($list_img));

        return view('manager.rooms.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $hotel = Hotel::where('user_id',$user_id)->first();
        $hotel_id = $hotel->id;

        $roomType = RoomType::where('status', RoomTypeStatus::ACTIVE)->get();

        return view('manager.rooms.form',compact('user_id','hotel_id', 'roomType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $room = new Room();
        $room->name = $data['name'];
        $room->price = $data['price'];
        $room->description = $data['description'];
        $room->room_type_id = $data['roomType'];
        // $room->user_id = $data['user'];
        $room->hotel_id = $data['hotel'];
        $bg_img = $request->file('bg');

        if ($bg_img) {
            $get_name_image = $bg_img->getClientOriginalName(); //hinh1.jpg
            $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
            $new_image = $name_image.rand(0,99).'.'.$bg_img->getClientOriginalExtension(); //hinh128.jpg
            $bg_img->move('img/rooms/' ,$new_image);
            $room->background = $new_image;
        }

        $img = $request->file('img');

        if($img) {
            foreach ($img as $key => $value) {
                $get_name_image = $value->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$value->getClientOriginalExtension(); //hinh128.jpg
                $value->move('img/rooms/' ,$new_image);
                $images['hinh'. ++$key] = $new_image;
            }

            $room->img = json_encode($images);
        }

        $room->save();
        return redirect(url('/manager/room'))->with('message','Create Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room = Room::find($id);
        $roomType = RoomType::where('status', RoomTypeStatus::ACTIVE)->get();
        return(view('manager.rooms.detail',compact('room','roomType')));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $room = Room::find($id);
        $hotel_id = $room->hotel_id;
        $hotel = Hotel::find($hotel_id);
        $user_id = $hotel->user_id;
        $roomType = RoomType::where('status', RoomTypeStatus::ACTIVE)->get();
        return view('manager.rooms.form',compact('room','hotel_id','user_id','roomType'));
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
        // $id = auth()->user()->id;
        // $hotel = Hotel::where('user_id',$id)->first();
        // $list = Room::where('hotel_id',$hotel->id)->get();

        $data = $request->all();
        $room = Room::find($id);
        $room->name = $data['name'];
        $room->price = $data['price'];
        $room->description = $data['description'];
        $room->room_type_id = $data['roomType'];
        
        // $room->user_id = $data['user'];
        $room->hotel_id = $data['hotel'];
        $bg_img = $request->file('bg');

        if ($bg_img) {
            if (!empty($room->background)) {
                unlink('img/rooms/'.$room->background);
            }
            $get_name_image = $bg_img->getClientOriginalName(); //hinh1.jpg
            $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
            $new_image = $name_image.rand(0,99).'.'.$bg_img->getClientOriginalExtension(); //hinh128.jpg
            $bg_img->move('img/rooms/' ,$new_image);
            $room->background = $new_image;
        }
        $img = $request->file('img');

        if($img) {
            foreach ($img as $key => $value) {
                $get_name_image = $value->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$value->getClientOriginalExtension(); //hinh128.jpg
                $value->move('img/rooms/' ,$new_image);
                $images['hinh'. ++$key] = $new_image;
            }

            $room->img = json_encode($images);
        }

        $room->save();
        return redirect(url('/manager/room'))->with('message','Update Successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $room = Room::find($id);
        if ($room->status == 0) {
            $room->delete();
        }
        return redirect()->back();
    }
}
