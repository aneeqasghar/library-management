<?php

namespace App\Actions;

use App\Models\BookUser;
use App\Enums\BookUser as BookUserStatus;
use App\Enums\User as UserStatus;
use Illuminate\Support\Carbon;

class BanUsers
{
    public function handle(): void
    {
        $records = BookUser::where('status', BookUserStatus::OVERDUE)
            ->whereDate('due_at', '<', Carbon::today()->subDays(30))
            ->with('user')
            ->get();

        foreach ($records as $record) {
            if ($record->user && $record->user?->status !== UserStatus::BANNED) {
                $record->user->update(['status' => UserStatus::BANNED]);
            }
        }
    }
}
