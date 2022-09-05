<?php

namespace Database\Factories;

use App\Enums\AffiliatorStatus;
use App\Enums\RequestStatus;
use App\Models\PaymentRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::query()->where('is_affiliator', AffiliatorStatus::YES)->where('money', '>', 0)->inRandomOrder()->value('id'),
            'amount' => rand(100, 500),
            'request_date' => Carbon::now()->addHours(rand(7, 22)),
            'status' => rand(RequestStatus::REQUEST, RequestStatus::REJECT),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (PaymentRequest $paymentRequest) {
            if ($paymentRequest->status == RequestStatus::REJECT) {
                $paymentRequest->payment_date = Carbon::parse($paymentRequest->request_date)->addHours(rand(1, 12));
                $paymentRequest->reject_cause = $this->faker->text();
                $paymentRequest->save();
            }
            if ($paymentRequest->status == RequestStatus::APPROVE) {
                $paymentRequest->payment_date = Carbon::parse($paymentRequest->request_date)->addHours(rand(1, 12));
                $paymentRequest->save();
            }
        });
    }
}
