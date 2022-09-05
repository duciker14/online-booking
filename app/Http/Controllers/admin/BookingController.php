<?php

namespace App\Http\Controllers\admin;

use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use App\Enums\RoomStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use BenSampo\Enum\Rules\EnumValue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Booking::with('user:id,name,email,phone');

        if($request->has('hotel') && $request->hotel != 'all') {
            $query->whereHas('room', function ($q) use($request) {
                return $q->where('hotel_id', $request->hotel);
            });
        }
        if($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        if($request->has('checkin') && $request->checkin != '') {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), $request->checkin);
        }
        if($request->has('checkout') && $request->checkout != '') {
            $query->where(DB::raw("(DATE_FORMAT(check_out,'%Y-%m-%d'))"), $request->checkout);
        }

        $bookings = $query->orderBy('id', 'DESC')->paginate(10);
        $hotels = Hotel::all();
        $bookingStatus = BookingStatus::asArray();
        $selectedHotel = $request->hotel;
        $selectedStatus = $request->status;
        $checkin = $request->checkin;
        $checkout = $request->checkout;


        return view('admin.bookings.list',
        compact('bookings', 'hotels', 'selectedHotel', 'bookingStatus', 'selectedStatus', 'checkin', 'checkout'));
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
        $status = BookingStatus::asArray();
        $statusPayment = PayStatus::asArray();

        return view('admin.bookings.detail', compact('booking', 'status', 'statusPayment'));
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
        $request->validate([
            'check_in' => 'required|after:' . Carbon::now(),
            'check_out' => 'required|after:check_in',
            'status' => ['required', new EnumValue(BookingStatus::class, false)],
            'payment_status' => ['required', new EnumValue(PayStatus::class, false)],
        ]);

        $booking = Booking::find($id);
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->status = $request->status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        return back()->withInput()->with('message', 'Update booking success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);
        if ($booking->status == BookingStatus::DELIVERY) {
            return back()->withInput()->with('error', 'Booking status cannot be deleted!');
        }
        Booking::where('id', $booking->id)->delete();
        $this->updateStatusRoomAvailability($booking->room_id);
        return back()->withInput()->with('message', 'Delete booking success!');
    }

    public function updateStatusRoomAvailability($id) {
        $room = Room::find($id);
        $room->status = RoomStatus::AVAILABLE;
        $room->save();
    }
}
