<?php

namespace App\Enums;

enum Role: string
{
    case FULL_ACCESS = 'full_access';
    case MEMBER = 'member';
}
