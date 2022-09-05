<?php

namespace App\Models;

use App\Enums\RoomStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'user_id', 'hotel_id', 'name', 'img', 'background', 'price', 'status',
    ];

    public function getRoomStatusName()
    {
        return ucfirst(strtolower(str_replace('_', ' ', RoomStatus::getKey($this->status))));
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeWithSearch($query)
    {
        if(request()->key) {
            $key = request()->get('key');
            $query->where('name', 'like', '%' . $key . '%');
        }
        return $query;
    }

    public function scopeSearchWithStatus($query)
    {
        if(request()->status) {
            $key = request()->status;
            $query->orWhere('status', RoomStatus::getValue($key));
        }
        return $query;
    }
    // public function scopeSearchWithHotel($query)
    // {
    //     if(request()->hotel) {
    //         $query->where('hotel_id', request()->hotel);
    //     }
    //     return $query;
    // }
    // public function scopeSearchWithType($query)
    // {
    //     if(request()->type) {
    //         $query->where('room_type_id', request()->type);
    //     }
    //     return $query;
    // }
}
