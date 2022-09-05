<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryHotel;
use App\Models\Hotel;
use Illuminate\Database\Seeder;

class CategoryHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotels = Hotel::pluck('id');
        $categories = Category::pluck('id');

        foreach ($categories as $category) {
            foreach ($hotels as $hotel) {
                CategoryHotel::firstOrCreate([
                    'category_id' => $category,
                    'hotel_id' => $hotel,
                ]);
            }
        }
    }
}
