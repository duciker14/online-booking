<?php

namespace App\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $dateFrom;
    private $dateTo;

    public function __construct($dateFrom = null, $dateTo = null) {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function  array(): array
    {
        $query = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->where('bookings.status', BookingStatus::DONE)
            ->orderBy('bookings.id','DESC')
            ->select('users.name as userName','hotels.name as hotelName', 'rooms.name as roomName','bookings.check_in','bookings.check_out','bookings.total','users.affiliator_ref as id_aff' );

            if ($this->dateFrom != null) {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '>=',$this->dateFrom);
            }

            if ($this->dateTo != null) {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '<=',$this->dateTo);
            }

        $revenues = $query->get()->toArray();
        foreach ($revenues as $value) {
            $profit = isset($value->id_aff) ? ($value->total)/100*20 : ($value->total)/100*30;
            $value->profit = $profit;
            unset($value->id_aff);
        }

        return $revenues;
    }
    public function headings() :array {
        return ["BOOKING USER", "HOTEL", "ROOM","CHECK IN", "CHECK OUT", "REVENUE ($)","PROFIT ($)"];
    }

}
