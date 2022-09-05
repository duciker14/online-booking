<?php

namespace App\Http\Controllers\manager;

use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookingStatus = BookingStatus::asArray();
        $bookings = Booking::withByHotel()->withStatus()->withUser()->withRoom()->withSortByDate()->withStatusPayment()->latest('check_in')->paginate(5);

        $paymentStatus = PayStatus::asArray();

        return view('manager.bookings.index', compact('bookings', 'bookingStatus', 'paymentStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = auth()->user()->id;
        $hotel = Hotel::where('user_id', $id)->first();
        $rooms = Room::where('hotel_id', $hotel->id)->where('status', RoomStatus::AVAILABLE)->get();

        // dd($hotel);
        return view('manager.bookings.add', compact('hotel', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'check_in' => 'required|after:' . Carbon::now(),
            'check_out' => 'required|after:check_in',
        ]);

        $date = Carbon::parse($request->check_out)->diffInDays($request->check_in);

        if($date != 0) {
            $total = $date * $request->price;
        }
        $total = $request->price;

        $booking = new Booking;
        $booking->user_id = auth()->user()->id;
        $booking->room_id = $request->room;
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->total = $total;
        $booking->note = $request->note;
        $booking->save();

        $room = Room::find($request->room);
        $room->status = RoomStatus::BOOKING;
        $room->save();

        return back()->withInput()->with('status','Booking created sucessfully');
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
        $booking = Booking::findOrFail($id);
        return view('manager.bookings.edit', compact('booking'));
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
        $booking = Booking::findOrFail($id);
        if(($booking->status == BookingStatus::CANCEL) || ($booking->status == BookingStatus::DONE) || ($booking->status == BookingStatus::SCHEDULE && $booking->payment_status == PayStatus::UNPAID)){
            $booking->delete();
            return redirect()->route('manager.bookings.index')->with('success', 'Booking has been deleted');
        } else {
            return redirect()->route('manager.bookings.index')->with('error', 'Booking can not delete');
        }
    }

    public function ajaxPriceRoom(Request $request) {
        $roomId = $request->roomId;
        $room = Room::find($roomId);
        return $room->price;
    }

    public function reject(Request $request, $id) {
        $booking = Booking::find($id);
        if($booking->status == BookingStatus::SCHEDULE && $booking->payment_status == PayStatus::UNPAID){
            $booking->status = BookingStatus::CANCEL;
            $booking->note = $request->cancel_cause;
            $booking->save();

            $this->updateStatusRoomAvailability($booking->room_id);
            return back()->withInput()->with('success', 'Cancel booking successfully!');
        }
        return back()->withInput()->with('error', 'Booking can not cancel');
    }

    public function confirmPaid(Request $request) {
        Booking::where('id', $request->id)->update([
            'payment_status' => PayStatus::PAID,
        ]);

        return 'Status Paid';
    }

    public function refundMoneyBooking($id) {
        $booking = Booking::find($id);
        $room = Room::find($booking->room_id);
        $user = User::find($booking->user_id);

        $moneyRefund = floor((strtotime($booking->check_out) - strtotime($booking->updated_at)) / 86400) * $room->price;
        $newTotal = $booking->total - $moneyRefund;

        $booking->total = $newTotal;
        $booking->status = BookingStatus::DONE;
        $booking->save();

        if($user->affiliator_ref) {
            $affiliator = User::find($user->affiliator_ref);
            $affiliator->money = $newTotal * 0.1;
            $affiliator->save();
        }

        $this->updateStatusRoomAvailability($booking->room_id);

        return back()->withInput()->with('success', 'Refund money successfully!');
    }

    public function updateStatusRoomAvailability($id)
    {
        $room = Room::find($id);
        $room->status = RoomStatus::AVAILABLE;
        $room->save();
    }

}
