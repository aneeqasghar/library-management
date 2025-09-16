<?php

namespace App\Console\Commands;

use App\Actions\SuspendUsers;
use Illuminate\Console\Command;

class SuspendUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:suspend-users-command';

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
        app(SuspendUsers::class)->handle();
        $this->info('Overdue users banned successfully.');
    }
}
