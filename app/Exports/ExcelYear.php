<?php

namespace App\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelYear implements FromArray, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        $revenueYear = DB::table('bookings')
            ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw('YEAR(check_in) as year, sum(total) as sumYear'))
            ->groupBy('year')
            ->orderBy('year', 'Asc')
            ->limit(5)
            ->get()->toArray();

        $revenueByAffiliator = DB::table('bookings')
            ->join('users', 'bookings.user_id', 'users.id')
            ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw('sum(total) as sumYear, users.affiliator_ref IS NOT NULL as ref, YEAR(check_in) as year'))
            ->groupBy('ref', 'year')
            ->get()->toArray();

        foreach ($revenueByAffiliator as $value) {
            if ($value->ref == 1) {
                foreach ($revenueYear as $val) {
                    if ($val->year == $value->year) {
                        $val->profit = ($val->sumYear * 0.3) - ($value->sumYear * 0.1);
                    }
                }
            } else {
                foreach ($revenueYear as $val) {
                    if ($val->year == $value->year) {
                        $val->profit = ($val->sumYear * 0.3);
                    }
                }
            }
        }
        return $revenueYear;
    }
    public function headings(): array
    {
        return ["YEAR", "TURNOVER ($)", "PROFIT ($)"];
    }
}
