<?php

namespace App\Console\Commands;

use App\Actions\BanUsers;
use Illuminate\Console\Command;

class BanUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ban-users-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ban users with overdue books past 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(BanUsers::class)->handle();
        $this->info('Overdue users banned successfully.');
    }
}
