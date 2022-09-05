<?php

namespace App\Http\Controllers\admin;

use App\Enums\AffiliatorStatus;
use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use App\Enums\RequestStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExport;
use App\Exports\ExcelMonth;
use App\Exports\ExcelYear;
use App\Models\Hotel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class DashBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $query = Booking::where('payment_status',PayStatus::PAID)->where('status', BookingStatus::DONE);
        if($request->has('filterChart') && $request->filterChart != 'all') {
            $query->where('check_in', '>=', Carbon::now()->subMonths($request->filterChart));
        }
        $arr = array();
        $check = false;
        $list = $query->get();
        foreach ($list as $key => $bk) {
            $lua = $bk->total * 0.7;
            if (count($arr) != 0) {
                for ($i=0; $i < count($arr) ; $i++) {
                   if (($arr[$i]['id'] == $bk->room->hotel->id) && ($check == false)) {
                        $arr[$i]['total'] += $lua;
                        $check = true;
                        break;
                   }
                }
                if ($check == false) {
                    $t = count($arr);
                    $arr[$t] = [
                        'id' => $bk->room->hotel->id,
                        'name' => $bk->room->hotel->name,
                        'total' => $lua
                    ];
                }
                $check = false;
            }else{
                $arr[0] = [
                    'id' => $bk->room->hotel->id,
                    'name' => $bk->room->hotel->name,
                    'total' => $lua
                ];
            }
        }
        $sum = 0;
        $sum_aff = 0;
        foreach($list as $key => $bk) {
            if ($bk->user->affiliator_ref != null) {
                $sum_aff += $bk->total;
            }
            $sum += $bk->total;
        }
        $sum = $sum - $sum_aff;

        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;

        $query = Booking::latest()
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->where('bookings.status', BookingStatus::DONE)
            ->orderBy('bookings.id','DESC')
            ->select('bookings.*','users.name as userName', 'rooms.name as roomName','hotels.name as hotelName','users.affiliator_ref as id_aff' );

            if($dateFrom) {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '>=', $dateFrom);
            }

            if($dateTo) {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '<=', $dateTo);
            }
        $revenues = $query->orderByDesc('bookings.check_in')->paginate(5);

        $totalManager = $this->totalManager();
        $totalTourist = $this->totalTourist();
        $bookingAndRevenue = $this->bookingAndRevenue();
        $hotelAndRoomSummary = $this->hotelAndRoomSummary();
        $pendingRequests = $this->pendingRequests();

        // dd($bookingAndRevenue);

        return view('admin.dashboards.index',compact('revenues', 'dateTo','dateFrom','arr','sum','sum_aff',
        'totalManager', 'totalTourist', 'bookingAndRevenue', 'hotelAndRoomSummary','pendingRequests'));
    }

    public function pendingRequests() {
        $request = DB::table('payment_request')->where('status', RequestStatus::REQUEST)->get();
        return count($request);
    }

    public function hotelAndRoomSummary() {
        $hotel = Hotel::all();
        $hotelRoom = $hotel->each->rooms->toArray();
        $total = [
            'hotels' => count($hotelRoom),
            'rooms' => 0
        ];
        foreach($hotelRoom as $key => $value) {
            $total['rooms'] += count($value['rooms']);
        }

        return $total;
    }

    public function bookingAndRevenue() {
        $bookings = Booking::all();

        $revenue = DB::table('bookings')
        ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw('sum(total) as revenue'))
            ->get()->toArray();

        $revenueByAffiliator = DB::table('bookings')
        ->join('users', 'bookings.user_id', 'users.id')
        ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw('sum(total) as revenue, users.affiliator_ref IS NOT NULL as ref'))
            ->groupBy('ref')
            ->get()->toArray();

        foreach ($revenueByAffiliator as $value) {
            if ($value->ref == 1) {
                foreach ($revenue as $val) {
                    $val->profit = ($val->revenue * 0.3) - ($value->revenue * 0.1);
                }
            } else {
                foreach ($revenue as $val) {
                    $val->profit = ($val->revenue * 0.3);
                }
            }
        }
        $total = [
            'bookings' => count($bookings),
            'revenue' => $revenue[0]->revenue,
            'profit' => $revenue[0]->profit,
        ];
        return $total;
    }

    public function totalManager() {
        $users = User::where('role', UserRole::MANAGER)->get();
        $total = count($users);
        return $total;
    }

    public function totalTourist() {
        $users = User::where('role', UserRole::TOURIST)
        ->select(DB::raw('count(role) as total, is_affiliator'))
        ->groupBy('is_affiliator')
        ->get()->toArray();
        return $users;
    }

    public function export_csvBooking(Request $request){
        $from = $request->dateFrom;
        $to = $request->dateTo;

        return Excel::download(new ExcelExport($from, $to), 'RevenueByBooking.csv' );
    }
    public function export_csvMonth(){
        return Excel::download(new ExcelMonth, 'RevenueMonth.csv' );
    }
    public function export_csvYear(){
        return Excel::download(new ExcelYear, 'RevenusYear.csv' );
    }
}
