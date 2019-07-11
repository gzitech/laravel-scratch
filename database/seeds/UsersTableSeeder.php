<?php

use App\Contracts\Repositories\RoleRepository;
use App\Contracts\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $role, $user;

    public function __construct(RoleRepository $role, UserRepository $user)
    {
        $this->role = $role;
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
            'email' => 'admin@master.com',
            'password' => bcrypt('123455'),
            'right' => 0,
            'email_verified_at' => now(),
        ])->roles()->attach([
            $this->role->Owner(),
        ]);;
    }
}
