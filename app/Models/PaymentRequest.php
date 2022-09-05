<?php

namespace App\Models;

use App\Enums\RequestStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRequest extends Model
{
    use HasFactory;

    protected $table = "payment_request";

    protected $fillable = [
        'user_id', 'amount', 'reject_cause', 'request_date', 'status', 'payment_day', 'status'
    ];

    public function getPayemntRequestStatusName()
    {
        return ucfirst(strtolower(RequestStatus::getKey($this->status)));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
