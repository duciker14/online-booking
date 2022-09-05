<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const ADMIN = 0;
    const MANAGER = 1;
    const TOURIST = 2;
}
