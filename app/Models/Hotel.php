<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;


    public function scopeSearch($query){
        if($key = request()->key){
            $query->where('name', 'like', '%'.$key.'%')
                ->orwhere('address', 'like', '%'.$key.'%');

        }
        return $query;
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->orderBy('reviews.id', 'DESC');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //
    public function categories(){
        return $this->belongsToMany(Category::class,'category_hotel')->where('status', CategoryStatus::SHOW);
    }
}
