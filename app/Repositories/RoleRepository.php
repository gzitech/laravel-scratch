<?php

namespace App\Repositories;

use App\Role;
use App\Contracts\Repositories\RoleRepository as Contract;
use Carbon\Carbon;

class RoleRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function getRoles($site_id)
    {
        if(config('app.paginate_type') == 'paginate') {
            return Role::where('site_id', $site_id)->paginate(config("app.max_page_size"));
        } else {
            return Role::where('site_id', $site_id)->simplePaginate(config("app.max_page_size"));
        }
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
}
