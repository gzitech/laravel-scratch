<?php

namespace App\Repositories;

use App\Role;
use App\User;
use App\Contracts\Repositories\RoleRepository as Contract;
use Carbon\Carbon;

class RoleRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function getRoles($site_id, $key)
    {
        $query = Role::where([['site_id', $site_id], ['role_name', 'LIKE', "%{$key}%"]]);

        return paginate($query, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getRolesByUserId($site_id, $user_id, $key)
    {
        $user = User::find($user_id);
        
        return $this->getRolesByUser($site_id, $user, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getRolesByUser($site_id, User $user, $key)
    {
        $query = $user->roles()->where([['site_id', $site_id], [function($query) use($key) {
            $query->where('role_name', 'LIKE', "%{$key}%")->orWhere('role_description', 'LIKE', "%{$key}%");
        }]]);

        return paginate($query, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Role::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $role = Role::create($data);

        return $role;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        Role::where('id', $id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateRight($id, $userRight, array $rights)
    {
        $val = 0;

        foreach($rights as $right) {
            $val = $val | $right;
        }

        $val = $val & $userRight;

        Role::where('id', $id)->update(['right' => $val]);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        Role::destroy($id);
    }
}
