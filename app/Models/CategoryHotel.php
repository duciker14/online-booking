<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHotel extends Model
{
    use HasFactory;

    protected $table = "category_hotel";

    public $timestamps = false;
}
