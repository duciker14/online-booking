<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class PayStatus extends Enum
{
    const UNPAID =   0;
    const WAIT_ACCEPT = 1;
    const PAID =   2;
}
