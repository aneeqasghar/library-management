<?php

namespace App\Console\Commands;

use App\Actions\SuspendUsers as SuspendUsersAction;
use Illuminate\Console\Command;

class SuspendUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:suspend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suspend users with overdue books past 60 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(SuspendUsersAction::class)->handle();
        $this->info('Overdue users suspended successfully.');
    }
}
