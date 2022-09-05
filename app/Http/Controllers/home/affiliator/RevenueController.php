<?php

namespace App\Http\Controllers\home\affiliator;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $yearRequest = $request->year;
        $monthRequest = $request->month;
        $dateRequest = $request->date;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;

        $query = Booking::latest()
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->select('bookings.*','users.name as userName', 'rooms.name as roomName','hotels.name as hotelName' )
            ->where('bookings.status', BookingStatus::DONE)
            ->orderBy('bookings.check_in','DESC')
            ->where('users.affiliator_ref', auth()->user()->id);
            
            if($request->has('year') && $request->year != 'all') {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y'))"), $request->year);
            }
    
            if($request->has('month') && $request->month != 'all') {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%c'))"), $request->month);
            }
    
            if($request->has('date') && $request->date != 'all') {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%e'))"), $request->date);
            }

        if($dateFrom) {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '>=', $dateFrom);
        }

        if($dateTo) {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '<=', $dateTo);
        }

        $revenues = $query->orderByDesc('bookings.check_in')->paginate(5);

        $revenueMonth = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->where('bookings.status', BookingStatus::DONE)
            ->where('users.affiliator_ref', auth()->user()->id)
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '<=', Carbon::now()->format('Y-m'))
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '>', Carbon::now()->subMonths(6)->format('Y-m'))
            ->select(DB::raw("(DATE_FORMAT(check_in,'%Y-%m')) as month, sum(total) as sumMonth"))
            ->groupBy('month')
            ->orderBy('month', 'Asc')
            ->get();

        $revenueYear = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->where('bookings.status',BookingStatus::DONE)
            ->where('users.affiliator_ref', auth()->user()->id)
            ->select(DB::raw('sum(total) as sumYear, YEAR(check_in) as year'))
            ->groupBy('year')
            ->orderBy('year', 'Asc')
            ->limit(5)
            ->get();

        return view('home.affiliator.revenues.index', compact('revenues','revenueYear','revenueMonth','yearRequest','monthRequest','dateRequest'));
    }

}
