<?php

namespace App\Http\Controllers\manager;

use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use App\Exports\RevenueByBookingExport;
use App\Exports\RevenueByMonthExport;
use App\Exports\RevenueByYearExport;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query = Booking::where('payment_status',PayStatus::PAID)->where('status', BookingStatus::DONE);
        if($request->has('filterChart') && $request->filterChart != 'all') {
            $query->where('check_in', '>=', Carbon::now()->subMonths($request->filterChart));
        }
        
        $hotelId = auth()->user()->hotel->id;
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;

        $query = DB::table('bookings')->latest()
        ->join('users', 'bookings.user_id', 'users.id')
        ->join('rooms', 'bookings.room_id', 'rooms.id')
        ->join('hotels', 'rooms.hotel_id', 'hotels.id')
        ->orderBy('bookings.id','DESC')
        ->select('bookings.*', 'users.name as userName', 'rooms.name as roomName')
        ->where([
            'hotels.id' => $hotelId,
            'bookings.status' => BookingStatus::DONE,
        ]);

        if($dateFrom) {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '>=', $dateFrom);
        }
        if($dateTo) {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '<=', $dateTo);
        }
        $revenues = $query->paginate(5);

        $revenue = [];
        $totalByMale = [];
        $totalByFemale = [];
        $totalAffiliators = 0;
        
        $ageTotal = DB::table('bookings')
        ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
        ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
        ->join('users', 'bookings.user_id', 'users.id')
        ->where('hotels.user_id', auth()->user()->id)
        ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.birthdate), current_date) AS age, SUM(bookings.total) as total")
        ->where([
            'hotels.id' => $hotelId,
            'bookings.payment_status' => PayStatus::PAID,
            'bookings.status' => BookingStatus::DONE
        ])
        ->groupBy('birthdate')
        ->get();

        $bookings = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->join('users', 'bookings.user_id', 'users.id')
            ->selectRaw('users.gender, sum(bookings.total) as total')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.payment_status' => PayStatus::PAID,
                'bookings.status' => BookingStatus::DONE
            ])
            ->groupBy('gender')
            ->get();

        $totalAffiliator = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->join('users', 'bookings.user_id', 'users.id')
            ->selectRaw('users.affiliator_ref, sum(bookings.total) as totalAffiliator')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.payment_status' => PayStatus::PAID,
                'bookings.status' => BookingStatus::DONE
            ])
            ->whereNotNull('users.affiliator_ref')
            ->groupBy('affiliator_ref')
            ->get();    

            foreach($totalAffiliator as $total){
                $totalAffiliators += $total->totalAffiliator;
            }

        $totalNotAffiliator = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->join('users', 'bookings.user_id', 'users.id')
            ->selectRaw('users.affiliator_ref, sum(bookings.total) as totalNotAffiliator')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.payment_status' =>  PayStatus::PAID,
                'bookings.status' => BookingStatus::DONE
            ])
            ->whereNull('users.affiliator_ref')
            ->groupBy('affiliator_ref')
            ->first();

        $revenueYear = $this->revenueByYear($hotelId);
        $revenueByMonth = $this->revenueByMonth($hotelId);
        // $revenueByBooking = $this->revenueByBooking($request, $hotelId);
        $bookingAndRevenue = $this->bookingAndRevenue();


        // foreach ($revenueByMonth as $value) {
        //     $profit = $value->sumMonth * 0.7;
        //     $value->profit = $profit;
        //     dd($value);
        // }

        return view('manager.dashboards.index', compact(
            'bookings', 'ageTotal', 'totalAffiliators',
            'totalNotAffiliator', 
            'revenueYear','revenueByMonth', 
            // 'revenueByBooking',
            'bookingAndRevenue', 'revenues', 'dateTo','dateFrom'
        ));
    }

    public function bookingAndRevenue() {
        $bookings = Booking::join('rooms', 'bookings.room_id', '=', 'rooms.id')
        ->join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
            ->where('hotels.id', auth()->user()->hotel->id)
            ->get();

        $revenue = DB::table('bookings')
        ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw('sum(total) as revenue'))
            ->get()->toArray();

        $total = [
            'bookings' => count($bookings),
            'revenue' => $revenue[0]->revenue,
        ];
        return $total;
    }

    public function revenueByYear($hotelId) {
        return DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.status' => BookingStatus::DONE,
            ])
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y'))"), '<=', Carbon::now()->format('Y'))
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y'))"), '>', Carbon::now()->subYears(5)->format('Y'))
            ->select(DB::raw('sum(total) as sumYear, YEAR(check_in) as year'))
            ->groupBy('year')
            ->orderBy('year', 'Asc')
            ->get();
    }

    public function revenueByMonth($hotelId) {
        return DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.status' => BookingStatus::DONE,
            ])
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '<=', Carbon::now()->format('Y-m'))
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '>', Carbon::now()->subMonths(6)->format('Y-m'))
            ->select(DB::raw('check_in as month, sum(total) as sumMonth'))
            ->groupBy('month')
            ->orderBy('month', 'Asc')
            ->get()->toArray();
    }

    public function revenueByBooking(Request $request, $hotelId) {
        $query = DB::table('bookings')
            ->join('users', 'bookings.user_id', 'users.id')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->select('bookings.*', 'users.name as userName', 'rooms.name as roomName')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.status' => BookingStatus::DONE,
            ]);

        if($request->has('year') && $request->year != 'all') {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y'))"), $request->year);
        }

        if($request->has('month') && $request->month != 'all') {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%c'))"), $request->month);
        }

        if($request->has('date') && $request->date != 'all') {
            $query->where(DB::raw("(DATE_FORMAT(check_in,'%e'))"), $request->date);
        }

        $revenue = $query->orderByDesc('bookings.check_in')->paginate(5);

        return $revenue;
    }

    public function export_csvBooking(Request $request)
    {
        $from = $request->dateFrom;
        $to = $request->dateTo;

        return Excel::download(new RevenueByBookingExport($from, $to), 'RevenueBookingByHotel.csv');
    }
    public function export_csvMonth()
    {
        return Excel::download(new RevenueByMonthExport, 'RevenueMonthByHotel.csv');
    }
    public function export_csvYear()
    {
        return Excel::download(new RevenueByYearExport, 'RevenusYearByHotel.csv');
    }
}
