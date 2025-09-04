<?php

namespace App\Enums;

enum BookUserStatus: string
{
    case AVAILABLE = 'available';
    case BORROWED = 'borrowed';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';
    case SETTLED = 'settled';
}
