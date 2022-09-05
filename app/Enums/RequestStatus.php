<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RequestStatus extends Enum
{
    const REQUEST =   0;
    const APPROVE =   1;
    const REJECT = 2;
}
