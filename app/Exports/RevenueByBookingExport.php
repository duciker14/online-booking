<?php

namespace App\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RevenueByBookingExport implements FromArray, WithHeadings
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

    public function array(): array
    {
        $hotelId = auth()->user()->hotel->id;
        $query = DB::table('bookings')
            ->join('users', 'bookings.user_id', 'users.id')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.status' => BookingStatus::DONE,
            ])
            ->orderBy('bookings.id','DESC')
            ->select('users.name as userName','rooms.name as roomName', 'bookings.check_in', 'bookings.check_out', 'bookings.total');

            if ($this->dateFrom != null) {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '>=',$this->dateFrom);
            }

            if ($this->dateTo != null) {
                $query->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m-%d'))"), '<=',$this->dateTo);
            }

        $revenues = $query->get()->toArray();
        foreach ($revenues as $value) {
            $profit = $value->total * 0.7;
            $value->profit = $profit;
        }

        return $revenues;
    }

    public function headings(): array
    {
        return ["User Booking", "Room", "Check In", "Check Out", "Revenue ($)", "Profit ($)"];
    }
}
