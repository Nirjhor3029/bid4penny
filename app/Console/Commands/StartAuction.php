<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartAuction extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:start-auction';
    protected $signature = 'auction:start';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';
    protected $description = 'Start the auction automatically at a fixed time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Auction start logic, e.g., setting auction status in the database
        // Example: Auction::query()->update(['status' => 'active']);

        // Notify clients
        Broadcast(new \App\Events\AuctionStarted());

        $this->info('Auction started successfully.');
    }
}
