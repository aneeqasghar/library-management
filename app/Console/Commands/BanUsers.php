<?php

namespace App\Console\Commands;

use App\Actions\BanUsers as BanUsersAction;
use Illuminate\Console\Command;

class BanUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:ban';

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
        app(BanUsersAction::class)->handle();
        $this->info('Overdue users banned successfully.');
    }
}
