<?php

namespace App\Console\Commands;

use App\Actions\MarkOverdueBooks as MarkOverdueBooksAction;
use Illuminate\Console\Command;

class MarkOverdueBooks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'books:overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark books past due date as overdue';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app(MarkOverdueBooksAction::class)->handle();
        $this->info('Books marked overdued successfully.');
    }
}
