<?php

namespace App\Actions;

use App\Models\BookUser;
use App\Enums\BookUser as BookUserStatus;
use App\Enums\Book as BookStatus;
use Illuminate\Support\Carbon;

class MarkOverdueBooks
{
    public function __invoke(): void
    {
        $overdueRecords = BookUser::where('status', '!=', BookUserStatus::RETURNED)
            ->where('status', '!=', BookUserStatus::OVERDUE)
            ->whereDate('due_at', '<', Carbon::today())
            ->get();

        foreach ($overdueRecords as $record) {
            $record->update(['status' => BookUserStatus::OVERDUE]);
        }
    }
}
