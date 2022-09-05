<?php

namespace App\Models;

use App\Enums\RoomTypeStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'room_type';

    protected $fillable = [
        'name',
        'status'
    ];

    public function getRoomTypeStatusName() {
        return ucfirst(strtolower(str_replace('_', ' ', RoomTypeStatus::getKey($this->status))));
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
