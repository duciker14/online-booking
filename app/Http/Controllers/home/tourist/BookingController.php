<?php

namespace App\Http\Controllers\home\tourist;

use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($hotel_id, $room_id)
    {

        $room = Room::where('id', $room_id)->first();
        if($room->status == RoomStatus::AVAILABLE){
            return view('home.tourist.bookings.index', compact('room'));
        }else{
            return redirect('/');
        }
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
    public function store(Request $request, $room_id)
    {
        $room = Room::where('id', $room_id)->first();

        $request->validate([
            'check_in' => 'required|after:' . Carbon::now(),
            'check_out' => 'required|after:check_in',
        ]);

        DB::beginTransaction();
        
        $checkin = Carbon::parse($request->check_in);
        $checkout = Carbon::parse($request->check_out);

        $total_day = $checkin->diffInDays($checkout, false);
        $total_price = $total_day * $room->price;

        try {
            Booking::insert([
                'user_id' => auth()->user()->id,
                'room_id' => $room->id,
                'check_in' => $request->check_in,
                'check_out' => $request->check_out,
                'total' => $total_price,
                'status' => BookingStatus::SCHEDULE,
                'payment_status' => PayStatus::UNPAID,
                'note' => $request->note
            ]);
            $room->update([
                'status' => RoomStatus::BOOKING
            ]);
            DB::commit();
            return redirect()->route('user.list-booking')->with('success', 'Booking success!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error("Message: " . $e->getMessage() . 'on Line: ' . $e->getLine());
            return back()->withInput()->with('error', 'Please come back later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $booking = Booking::find($id);
        $status = BookingStatus::getKey($booking->status);
        $paymentStatus = PayStatus::getKey($booking->payment_status);

        return view('home.tourist.bookings.detail', compact('booking', 'status', 'paymentStatus'));
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
        //
    }

    public function listBooking()
    {
        $userId = auth()->user()->id;

        $bookings = Booking::where('user_id', $userId)->paginate(10);

        return view('home.tourist.bookings.list-booking', compact('bookings'));
    }

    public function cancelBooking($id)
    {
        $booking = Booking::where('id', $id)->first();
        $check_in = $booking->check_in;
        $subDate = Carbon::createFromTimeStamp(strtotime($check_in))->subDay()->format('Y-m-d');
        $addHours = Carbon::createFromTimeStamp(strtotime($subDate))->addHour(14);
        $now = Carbon::now()->format('Y-m-d h:i:s A');
        $dayCancel = date('Y-m-d h:i:s A', strtotime($addHours));
        $timeOfNow = strtotime($now);
        $timeCancel = strtotime($dayCancel);

        if($booking->status == BookingStatus::SCHEDULE && $booking->payment_status == PayStatus::UNPAID){
            if($timeOfNow <= $timeCancel){
                DB::beginTransaction();
                try {
                    $booking->update([
                        'status' => BookingStatus::CANCEL
                    ]);
                    Room::find($booking->room_id)->update([
                        'status' => RoomStatus::AVAILABLE
                    ]);
                    DB::commit();
                    return redirect()->back()->with('success', 'Cancel successfully!');
                } catch (Exception $e) {
                    DB::rollback();
                    Log::error("Message: " . $e->getMessage() . 'on Line: ' . $e->getLine());
                    return redirect()->back()->with('error', 'Cancel failed!');
                }
            }
            return redirect()->back()->with('error', 'Cancel failed!');
        }
        return redirect()->back()->with('error', 'Cancel failed!');
    }

    public function refundBooking($id)
    {
        $booking = Booking::where('id', $id)->first();
        $check_out = $booking->check_out;
        $subADay = Carbon::createFromTimeStamp(strtotime($check_out))->subDay()->format('Y-m-d h:i:s A');
        $now = Carbon::now()->format('Y-m-d h:i:s A');
        $timeSubADayOfCheckout = strtotime($subADay);
        $timeOfNow = strtotime($now);
        
        if($booking->status == BookingStatus::DELIVERY && $booking->payment_status == PayStatus::PAID){
            if($timeSubADayOfCheckout > $timeOfNow){
                DB::beginTransaction();
                try {
                    $booking->update([
                        'status' => BookingStatus::REFUND,
                        'updated_at' => Carbon::now()
                    ]);
                    DB::commit();
                    return redirect()->back()->with('success', 'Refund successfully!');
                } catch (Exception $e) {
                    DB::rollback();
                    Log::error("Message: " . $e->getMessage() . 'on Line: ' . $e->getLine());
                    return redirect()->back()->with('error', 'Refund failed!');
                }
            }
            return redirect()->back()->with('error', 'Refund failed!');

        }
        return redirect()->back()->with('error', 'Refund failed!');
    }

    public function paymentBooking($id)
    {
        $booking = Booking::where('id', $id)->first();
        if($booking->update([
            'payment_status' => PayStatus::WAIT_ACCEPT
        ])){
            return back()->with('success', 'Please wait for confirmation from the hotel!');
        }
        return back()->with('error', 'Payment failed');
        
        
    }

}
