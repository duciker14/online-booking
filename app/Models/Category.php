<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'status',
    ];

    public function scopeWithSearch($query)
    {
        if(request()->key) {
            $key = request()->get('key');
            $query->where('name', 'like', '%' . $key . '%');
        }
        return $query;
    }
    //
    public function hotels(){
        return $this->belongsToMany(Hotel::class,'category_hotel');
    }
}
