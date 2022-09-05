<?php

namespace Database\Factories;

use App\Enums\AffiliatorStatus;
use App\Enums\BookingStatus;
use App\Enums\PayStatus;
use App\Enums\RoomStatus;
use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::query()->where('role', UserRole::TOURIST)->where('is_affiliator', AffiliatorStatus::NO)->inRandomOrder()->value('id'),
            'room_id' => Room::query()->where('status', RoomStatus::AVAILABLE)->inRandomOrder()->value('id'),
            'check_in' => Carbon::today()->addDays(rand(1, 7)),
            'check_out' => Carbon::today()->addDays(rand(1, 7)),
            'total' => 100,
            'status' => rand(BookingStatus::SCHEDULE, BookingStatus::CANCEL),
            'payment_status' => PayStatus::UNPAID,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Booking $booking) {
            $room = Room::find($booking->room_id);

            $booking->check_out = Carbon::parse($booking->check_in)->addDays(rand(1, 7));
            $booking->total = floor((strtotime($booking->check_out) - strtotime($booking->check_in)) / 86400) * $room->price;
            $booking->save();

            if ($booking->status == BookingStatus::SCHEDULE) {
                $booking->payment_status = rand(PayStatus::UNPAID, PayStatus::PAID);
                $booking->save();
                $room->status = RoomStatus::BOOKING;
                $room->save();
            } elseif($booking->status == BookingStatus::CANCEL) {
                $booking->payment_status = PayStatus::UNPAID;
                $booking->note = $this->faker->text();
                $booking->save();
                $room->status = RoomStatus::AVAILABLE;
                $room->save();
            }elseif($booking->status == BookingStatus::DELIVERY) {
                $booking->payment_status = PayStatus::PAID;
                $booking->save();
                $room->status = RoomStatus::BOOKING;
                $room->save();
            } else{
                $booking->payment_status = PayStatus::PAID;
                $booking->save();
                $room->status = RoomStatus::AVAILABLE;
                $room->save();
            }
        });
    }
}
