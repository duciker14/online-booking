<?php

namespace App\Http\Controllers\home\tourist;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Post;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Hotel::all();
        $star = DB::table('reviews')
                    ->select(DB::raw('avg(rate) as start , hotel_id'))
                    ->groupBy('hotel_id')
                    ->orderBy('start','DESC')
                    ->limit(3)
                    ->get();
        $arr = array();
        for ($i=0; $i < count($star) ; $i++) {
            $hotel = Hotel::find($star[$i]->hotel_id);
            $arr[$i]['name'] = $hotel->name;
            $arr[$i]['address'] = $hotel->address;
            $arr[$i]['description'] = $hotel->description;
            $arr[$i]['images'] = $hotel->images;
            $arr[$i]['background'] = $hotel->background;
            $arr[$i]['id'] = $hotel->id;
            $arr[$i]['rate'] = round($star[$i]->start);
        }
        $slide_list = Hotel::all();
        foreach ($slide_list as $key => $value) {
            foreach ($value->categories as $key => $vl) {
                $value->category_name .= $vl->name;
            }
        }
        $trending = Hotel::orderBy('created_at','ASC')->limit(8)->get();
        $list_review = Review::with('user','hotel')->orderBy('rate', 'DESC')->limit(10)->get();
        $posts = Post::limit(4)->get();

        $path = public_path()."/json/";
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        File::put($path.'hotel.json',json_encode($slide_list));

        //

        return view('home.tourist.homepages.index',compact('list','arr','list_review','trending','slide_list', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list_hotel()
    {
        $slide_list = Hotel::all();
        $list = Hotel::paginate(6);
        return view('home.tourist.homepages.list',compact('list','slide_list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail_hotel($id)
    {
        $hotel = Hotel::find($id);
        $slide_list = Hotel::all();
        $str = file_get_contents('img/hotel/json_file/imghotel.json');
        $array = json_decode($str, true);
        $imagess = '';
        if ($array) {
            for ($i=0; $i < count($array) ; $i++) {
                if ($array[$i]['id'] == $id) {
                    $imagess = $array[$i]['images'];
                    break;
                }
            }
            $arr = json_decode($imagess,true);
        }else{
            $arr = '';
        }
        $count_review = Review::where('hotel_id',$id)->count();
        $star = DB::table('reviews')
                ->where('hotel_id',$id)
                ->avg('rate');
        $star = round($star,1);
        $list_room = Room::where('hotel_id',$id)->orderBy('name','ASC')->get();
        $review = Review::with('user')->where('hotel_id',$id)->orderBy('updated_at','DESC')->limit(2)->get();
        $detail_rate = null;
        if (auth()->check()) {
            if (isset($hotel)) {
                $detail_rate = Review::where('user_id',Auth::user()->id)->where('hotel_id',$hotel->id)->first();
            }
        }
        return view('home.tourist.homepages.detail',compact('hotel','slide_list','arr','count_review','star','list_room','review','detail_rate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail_room($id, $room_id)
    {
        $room = Room::with('hotel')->find($room_id);
        $slide_list = Hotel::all();
        $str = file_get_contents('img/rooms/json_file/imgroom.json');
        $array = json_decode($str, true);
        $images = '';
        if ($array) {
            for ($i=0; $i < count($array) ; $i++) {
                if ($array[$i]['id'] == $id) {
                    $images = $array[$i]['img'];
                    break;
                }
            }
            $arr = json_decode($images,true);
        }else{
            $arr = '';
        }

        return view('home.tourist.homepages.room_detail',compact('room','slide_list','arr'));
    }
    public function search_hotel(){
        if (isset($_GET['hotel'])) {
            $kq = $_GET['hotel'];
            $result = Hotel::where('name','LIKE','%'.$kq.'%')->orwhere('address','LIKE','%'.$kq.'%')->paginate(12);
            // dd($result);
        }
        $slide_list = Hotel::all();
        return view('home.tourist.homepages.search',compact('result','slide_list'));
    }

    public function about(){
        $slide_list = Hotel::all();
        return view('home.tourist.homepages.about',compact('slide_list'));
    }

    public function contact(){
        $slide_list = Hotel::all();
        return view('home.tourist.homepages.contact',compact('slide_list'));
    }

    public function sendContact(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required',
        ]);

        $content = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'content' => $request->content,
        ];

        Mail::send('emails.send-contact', $content, function ($message) use ($request) {
            $message->to(env('MAIL_FROM_ADDRESS'));
            $message->subject($request->subject);
        });

        return redirect()->back()->with('success', "Send Contact success!");
    }
}
