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

        return $this->paginate($query);
    }

    /**
     * {@inheritdoc}
     */
    public function getRolesByUserId($user_id, $key)
    {
        $user = $this->find($user_id);
        
        return $this->getRolesByUser($user, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getRolesByUser(User $user, $key)
    {
        $query = $user->roles()->where(function($query) use($key) {
            $query->where('role_name', 'LIKE', "%{$key}%")->orWhere('role_description', 'LIKE', "%{$key}%");
        });
        
        return $this->paginate($query);
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
    public function updateRight($id, array $rights)
    {
        $val = 0;

        foreach($rights as $right) {
            $val = $val | $right;
        }

        Role::where('id', $id)->update(['right' => $val]);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        Role::destroy($id);
    }

    /**
     * {@inheritdoc}
     */
    private function paginate($query)
    {
        if(config('app.paginate_type') == 'paginate') {
            return $query->paginate(config("app.max_page_size"));
        } else {
            return $query->simplePaginate(config("app.max_page_size"));
        }
    }
}
