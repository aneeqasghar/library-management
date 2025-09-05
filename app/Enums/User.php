<?php

namespace App\Enums;

enum User: string
{
    case ACTIVE = 'active';
    case BANNED = 'banned';
    case SUSPENDED = 'suspended';
}
