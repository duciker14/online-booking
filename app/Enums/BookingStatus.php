<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class BookingStatus extends Enum
{
    const SCHEDULE = 1;
    const DELIVERY = 2;
    const DONE = 3;
    const REFUND = 4;
    const CANCEL = 5;
}
