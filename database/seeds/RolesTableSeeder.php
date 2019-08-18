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
        $roles = config('rbac.roles');

        foreach($roles as $key=>$role) {
            $this->role->create($role);
        }
    }
}
