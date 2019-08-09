<?php

use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $role, $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->user->create([
            'first_name' => 'Sander',
            'last_name' => 'H',
            'email' => 'sander@gzitech.com',
            'password' => Hash::make('123455'),
            'right' => 63,
            'email_verified_at' => now(),
        ])->roles()->attach([
            config('rbac.roles')['owner']
        ]);
    }
}
