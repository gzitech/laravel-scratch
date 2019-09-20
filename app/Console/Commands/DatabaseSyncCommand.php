<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssky:sync
    {filename? : Specify a filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync database to file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filename = $this->argument('filename');

        $this->info("filename: " . $filename);
    }
}
