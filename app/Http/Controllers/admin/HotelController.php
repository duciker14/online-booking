<?php

namespace App\Http\Controllers\admin;

use App\Enums\BookingStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotels = Hotel::search()->orderBy('id','DESC')->paginate(10);
        $list_img = Hotel::select('id','images')->orderBy('id','ASC')->get();
        $json_img = public_path()."/img/hotel/json_file/";

        if (!is_dir($json_img)) {
            mkdir($json_img,0777,true);
        }

        return view('admin.hotels.index',compact('hotels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $age = array("H1"=>"h1.png","H2"=>"h2.png","H3"=>"h3.png","H4"=>"h4.png","H5"=>"h5.png","H6"=>"h6.png","H7"=>"h7.png","H8"=>"h8.png","H9"=>"h9.png","H10"=>"h10.png",);
        // dd(json_encode($age));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hotel = Hotel::find($id);
        $roomType = $hotel->rooms->each->roomType->groupBy(with('roomType.name'));
        $booking = 0;
        $star = 0;

        foreach ($hotel->rooms as $room) {
            $booking += count($room->bookings);
        }

        foreach($hotel->reviews as $review) {
            $star += $review->rate;
        }

        $star = $star / count($hotel->reviews);

        return view('admin.hotels.detail', compact('hotel', 'booking', 'roomType', 'star'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hotel = Hotel::find($id);
        return view('admin.hotels.form',compact('hotel'));
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

        // $request->validate([
        //     'name' => 'required',
        //     'address' => 'required',
        // ]);
        // $hotels->update($request->all());
        // return redirect()->route('admin.hotel.index');
        $data = $request->all();
        $hotel = Hotel::find($id);
        $hotel->name = $data['name'];
        $hotel->address = $data['address'];

        $bg_img = $request->file('bg');

        if ($bg_img) {
            if (!empty($hotel->background)) {
                unlink('img/hotel/'.$hotel->background);
            }
            $get_name_image = $bg_img->getClientOriginalName(); //hinh1.jpg
            $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
            $new_image = $name_image.rand(0,99).'.'.$bg_img->getClientOriginalExtension(); //hinh128.jpg
            $bg_img->move('img/hotel/' ,$new_image);
            $hotel->background = $new_image;
        }

        //them 10 anh
            $img1 = $request->file('img1');
            $img2 = $request->file('img2');
            $img3 = $request->file('img3');
            $img4 = $request->file('img4');
            $img5 = $request->file('img5');
            $img6 = $request->file('img6');
            $img7 = $request->file('img7');
            $img8 = $request->file('img8');
            $img9 = $request->file('img9');
            $img10 = $request->file('img10');
            $str = array();
            if ($img1) {
                $get_name_image = $img1->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img1->getClientOriginalExtension(); //hinh128.jpg
                $img1->move('img/hotel/' ,$new_image);
                $str['hinh1']  = $new_image;

            }
            if ($img2) {
                $get_name_image = $img2->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img2->getClientOriginalExtension(); //hinh128.jpg
                $img2->move('img/hotel/' ,$new_image);
                $str['hinh2']  = $new_image;

            }
            if ($img3) {
                $get_name_image = $img3->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img3->getClientOriginalExtension(); //hinh128.jpg
                $img3->move('img/hotel/' ,$new_image);
                $str['hinh3']  = $new_image;

            }
            if ($img4) {
                $get_name_image = $img4->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img4->getClientOriginalExtension(); //hinh128.jpg
                $img4->move('img/hotel/' ,$new_image);
                $str['hinh4']  = $new_image;

            }
            if ($img5) {
                $get_name_image = $img5->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img5->getClientOriginalExtension(); //hinh128.jpg
                $img5->move('img/hotel/' ,$new_image);
                $str['hinh5']  = $new_image;

            }
            if ($img6) {
                $get_name_image = $img6->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img6->getClientOriginalExtension(); //hinh128.jpg
                $img6->move('img/hotel/' ,$new_image);
                $str['hinh6']  = $new_image;

            }
            if ($img7) {
                $get_name_image = $img7->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img7->getClientOriginalExtension(); //hinh128.jpg
                $img7->move('img/hotel/' ,$new_image);
                $str['hinh7']  = $new_image;

            }
            if ($img8) {
                $get_name_image = $img8->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img8->getClientOriginalExtension(); //hinh128.jpg
                $img8->move('img/hotel/' ,$new_image);
                $str['hinh8']  = $new_image;

            }
            if ($img9) {
                $get_name_image = $img9->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img9->getClientOriginalExtension(); //hinh128.jpg
                $img9->move('img/hotel/' ,$new_image);
                $str['hinh9']  = $new_image;

            }
            if ($img10) {
                $get_name_image = $img10->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$img10->getClientOriginalExtension(); //hinh128.jpg
                $img10->move('img/hotel/' ,$new_image);
                $str['hinh10']  = $new_image;

            }
            $imge = json_encode($str);
            $hotel->images = $imge;
        //end them 10 anh
        $hotel->save();
        return redirect(url('/admin/hotel'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hotel = Hotel::find($id);
        $rooms = Room::where('hotel_id', $id)->get();

        if(count($rooms) > 0){
            foreach($rooms as $room) {
                if($room->status != RoomStatus::AVAILABLE) {
                    return redirect()->back()->with('error', 'Hotel in use');
                    break;
                }
            }
            $this->deleteRoomByHotel($id);
            $this->deleteReviewsByHotel($id);
            $this->deleteUserByHotel($hotel->user_id);

            $hotel->delete();
            return redirect()->route('admin.hotel.index')->with('success', 'Delete success');
        }
        $this->deleteRoomByHotel($id);
        $this->deleteReviewsByHotel($id);
        $this->deleteUserByHotel($hotel->user_id);
        $hotel->delete();
        return redirect()->route('admin.hotel.index')->with('success', 'Delete success');
    }

    public function deleteRoomByHotel($id) {
        $rooms = Room::all();
        $rooms->where('hotel_id', $id)->each->delete();
    }

    public function deleteUserByHotel($id) {
        $user = User::find($id);
        $user->delete();
    }

    public function deleteReviewsByHotel($id) {
        $rooms = Review::all();
        $rooms->where('hotel_id', $id)->each->delete();
    }
}
