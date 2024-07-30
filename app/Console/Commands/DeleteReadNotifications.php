<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteReadNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'read-notifications:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove seen notifications older than 10 days ago.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return DB::table('notifications')->whereNotNull('read_at')->whereDate('read_at', '<=', now()->subDays(10)->toDateTimeString())->delete();
    }
}
