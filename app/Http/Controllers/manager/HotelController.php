<?php

namespace App\Http\Controllers\manager;

use App\Enums\CategoryStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryHotel;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
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
        $category = Category::where('status', CategoryStatus::SHOW)->get();
        return view('manager.hotels.edit',compact('hotel','category'));
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

        return view('manager.hotels.index', compact('hotel', 'booking', 'roomType', 'star'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $data = $request->all();
        $hotel = Hotel::find($id);
        $hotel->name = $data['name'];
        $hotel->address = $data['address'];
        $hotel->description = $data['description'];
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

        $img = $request->file('img');

        if($img) {
            foreach ($img as $key => $value) {
                $get_name_image = $value->getClientOriginalName(); //hinh1.jpg
                $name_image = current(explode('.',$get_name_image)); // [0]=>'hinh1', [1]=>'jpg
                $new_image = $name_image.rand(0,99).'.'.$value->getClientOriginalExtension(); //hinh128.jpg
                $value->move('img/hotel/' ,$new_image);
                $images['hinh'. ++$key] = $new_image;
            }

            $hotel->images = json_encode($images);
        }

        $hotel->save();

        // DB::table('category_hotel')->where('hotel_id', $id)->delete();
        // foreach ($data['category'] as $key => $value) {
        //     DB::table('category_hotel')->updateOrInsert([
        //         'hotel_id' =>  $hotel->id,
        //         'category_id' => $value
        //     ]);
        // }
        // dd($data['category']);
        // return redirect(url('/manager/hotel'))->with('message','Update Successfully');
        return redirect(url('/manager/hotel/'.$id))->with('message','Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
