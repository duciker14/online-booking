<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id', 'room_id', 'check_in', 'check_out', 'total', 'status', 'payment_status', 'note', 'created_at', 'updated_at'
    ];

    public function getBookingStatusName()
    {
        return ucfirst(strtolower(str_replace('_', ' ', BookingStatus::getKey($this->status))));
    }

    public function getPaymentStatusName()
    {
        return ucfirst(strtolower(str_replace('_', ' ',PayStatus::getKey($this->payment_status))));
    }

    public function user()
    {
        return $this->belongsTo(User::class)->orderBy('gender', 'asc');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function scopeSearch($query){
        if($date = request()->date){
            $query->whereDay('check_in', '=', $date);
        }elseif($month = request()->month){
            $query->whereMonth('check_in', '=', $month);
        }elseif($year = request()->year){
            $query->whereYear('check_in', '=', $year);
        }
        return $query;
    }

    public function scopeWithUser($query){
        if($key = request()->key){
            return $query->whereHas('user', function($q) use($key) {
                $q->where('name', 'like', '%' . $key . '%');
            });
        }
    }

    public function scopeWithRoom($query){
        if($key = request()->key){
            return $query->orWhereHas('room', function($q) use($key) {
                $q->where('name', 'like', '%' . $key . '%');
            });
        }
    }

    public function scopeWithSortByDate($query){
        if(request()->check_in && request()->check_out){
            $check_in = request()->check_in;
            $check_out = request()->check_out;
            $query->whereBetween('check_in', [$check_in, $check_out]);
        }
        return $query;
    }


    public function scopeWithStatusPayment($query){
        $key = request()->key;
        if($key == 'paid'){
            $query->orWhere('payment_status', 'like', '%' . PayStatus::PAID . '%');
        }elseif($key == 'not' || $key == 'unpaid'){
            $query->orWhere('payment_status', 'like', '%' . PayStatus::UNPAID . '%');
        }
        return $query;
    }

    public function scopeWithByHotel($query)
    {
        return $query->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            // ->where('rooms.user_id', auth()->user()->id)
            ->where('hotels.user_id', auth()->user()->id)
            ->select('bookings.*');
    }

    public function scopeWithStatus($query)
    {
        if($key = request()->status){
            $query->where('bookings.status', BookingStatus::getValue($key));
        }
        return $query;
    }

}
