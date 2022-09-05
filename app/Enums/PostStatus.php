<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PostStatus extends Enum
{
    const PUBLISHED = 0;
    const DRAFT = 1;
}
