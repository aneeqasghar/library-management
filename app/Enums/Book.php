<?php

namespace App\Enums;

enum Book: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';
}
