<?php

use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $user;

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
            'first_name' => 'Admin',
            'last_name' => 'Master',
            'email' => 'admin@gzitech.com',
            'password' => Hash::make('123455'),
            'right' => 0,
            'email_verified_at' => now(),
        ])->roles()->attach([
            config('rbac.roles')['owner']['id']
        ]);
    }
}
