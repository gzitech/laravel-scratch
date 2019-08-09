<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Console\Command;

class RightUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'right:update
    {role_id? : update users.right by role.id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $user, $description = 'Update users.right';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $role_id = intval($this->argument('role_id'));

        if($role_id === 0) {
            DB::table('users')->chunkById(100, function ($users) {
                foreach ($users as $user) {
                    $this->user->updateRight($user->id);
                }
            });
        }

        $this->info("role_id: $role_id");
    }
}
