<?php

use App\Contracts\Repositories\RoleRepository;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    protected $role;

    public function __construct(RoleRepository $role)
    {
        $this->role = $role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->role->create([
            'role_name' => 'Owner',
            'role_description' => 'Administrator',
            'right' => 0,
        ]);
        
        $this->role->create([
            'role_name' => 'Member',
            'role_description' => 'General user',
            'right' => 0,
        ]);

        $this->role->create([
            'role_name' => 'Guest',
            'role_description' => 'Guest',
            'right' => 0,
        ]);
    }
}
