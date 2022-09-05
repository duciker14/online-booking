<?php

namespace App\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RevenueByMonthExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $hotelId = auth()->user()->hotel->id;
        $revenueMonth = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.status' => BookingStatus::DONE,
            ])
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '<=', Carbon::now()->format('Y-m'))
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '>', Carbon::now()->subMonths(6)->format('Y-m'))
            ->select(DB::raw("(DATE_FORMAT(check_in,'%m-%Y')) as month, sum(total) as sumMonth"))
            ->groupBy('month')
            ->orderBy('month', 'Asc')
            ->get()->toArray();

        foreach ($revenueMonth as $value) {
            $profit = $value->sumMonth * 0.7;
            $value->profit = $profit;
        }

        return $revenueMonth;
    }

    public function headings(): array
    {
        return ["Month", "Revenue ($)", "Profit ($)"];
    }
}
