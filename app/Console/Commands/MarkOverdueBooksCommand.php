<?php

namespace App\Console\Commands;

use App\Actions\MarkOverdueBooks;
use Illuminate\Console\Command;

class MarkOverdueBooksCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-books-command';

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
        app(MarkOverdueBooks::class)->handle();
        $this->info('Overdue users banned successfully.');
    }
}
