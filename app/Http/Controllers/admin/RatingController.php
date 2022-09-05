<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Review::with('user:id,name')->latest();

        if($request->has('hotel') && $request->hotel != 'all') {
            $query->where('hotel_id', $request->hotel);
        }

        if ($request->has('star') && $request->star != 'all') {
            $query->where('rate', $request->star);
        }

        $reviews = $query->orderBy('created_at', 'DESC')->paginate(15);
        $hotels = Hotel::all();

        return view('admin.rate.index', [
            'reviews' => $reviews,
            'hotels' => $hotels,
            'selectedHotel' => $request->hotel,
            'selectedStar' => $request->star
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_content(Request $request)
    {
        $data = $request->all();
        $rv = Review::where('hotel_id',$data['hotel_id'])->where('user_id',$data['user_id'])->first();
        $rv->content = $data['content'];
        $rv->created_at = Carbon::now();
        $rv->save();
        return redirect()->back();
    }
    public function dlt_rv($id){
        $rv = Review::find($id);
        $rv->delete();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Review::find($id)->delete();
        return back()->withInput()->with('message', 'Delete reviews success!');
    }

    public function insert_rating(Request $request)
    {

        DB::table('reviews')->updateOrInsert([
            'user_id' => $request->user_id,
            'hotel_id' => $request->hotel_id
        ],[
            'rate' => $request->index
        ]);
    }
}
