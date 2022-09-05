<?php

namespace App\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RevenueByYearExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        $hotelId = auth()->user()->hotel->id;
        $revenueYear = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', 'hotels.id')
            ->where([
                'hotels.id' => $hotelId,
                'bookings.status' => BookingStatus::DONE,
            ])
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y'))"), '<=', Carbon::now()->format('Y'))
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y'))"), '>', Carbon::now()->subYears(5)->format('Y'))
            ->select(DB::raw('YEAR(check_in) as year, sum(total) as sumYear'))
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->get()->toArray();

        foreach ($revenueYear as $value) {
            $profit = $value->sumYear * 0.7;
            $value->profit = $profit;
        }

        return $revenueYear;
    }

    public function headings(): array
    {
        return ["Year", "Revenue ($)", "Profit ($)"];
    }
}
