<?php

namespace App\Enums;

enum BookUser: string
{
    case BORROWED = 'borrowed';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';
}
