<?php

namespace App\Exports;

use App\Enums\BookingStatus;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelMonth implements FromArray, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function array(): array
    {
        $revenueMonth = DB::table('bookings')
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '<=', Carbon::now()->format('Y-m'))
            ->where(DB::raw("(DATE_FORMAT(check_in,'%Y-%m'))"), '>', Carbon::now()->subMonths(6)->format('Y-m'))
            ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw("(DATE_FORMAT(check_in,'%Y-%m')) as month, sum(total) as sumMonth"))
            ->groupBy('month')
            ->orderBy('month', 'Asc')
            ->limit(6)
            ->get()->toArray();

        $revenueByAffiliator = DB::table('bookings')
            ->join('users', 'bookings.user_id', 'users.id')
            ->where('bookings.status', BookingStatus::DONE)
            ->select(DB::raw("sum(total) as sumMonth, users.affiliator_ref IS NOT NULL as ref, DATE_FORMAT(check_in,'%Y-%m') as month"))
            ->groupBy('ref', 'month')
            ->get()->toArray();

        foreach ($revenueByAffiliator as $value) {
            if ($value->ref == 1) {
                foreach ($revenueMonth as $val) {
                    if ($val->month == $value->month) {
                        $val->profit = ($val->sumMonth * 0.3) - ($value->sumMonth * 0.1);
                    }
                }
            } else {
                foreach ($revenueMonth as $val) {
                    if ($val->month == $value->month) {
                        $val->profit = ($val->sumMonth * 0.3);
                    }
                }
            }
        }
        return $revenueMonth;
    }
    public function headings(): array
    {
        return ["MONTH", "TURNOVER ($)", "PROFIT ($)"];
    }
}
