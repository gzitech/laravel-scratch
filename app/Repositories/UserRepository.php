<?php

namespace App\Repositories;

use App\User;
use App\Role;
use App\Contracts\Repositories\UserRepository as Contract;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class UserRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function current()
    {
        if (Auth::check()) {
            return $this->find(Auth::id())->shouldHaveSelfVisibility();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function paginate()
    {
        if(config('app.paginate_type') == 'paginate') {
            return User::paginate(config("app.max_page_size"));
        } else {
            return User::simplePaginate(config("app.max_page_size"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $password = '';

        if(empty($data['password'])) {
            $password = str_random(10);
            $data['password'] = Hash::make($password);
        }

        $user = User::create($data);

        if(!empty($password)) {
            $user->password = $password;
            event(new Registered($user));
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        User::find($id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateRight($id) {

        $user = User::find($id);

        $right = 0;
        
        $roles = $user->roles;

        foreach($roles as $role) {
            $right = $right | $role->right;
        }

        $user->right = $right;
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function updateRights() {
        User::chunkById(100, function ($users) {
            foreach ($users as $user) {
                $this->updateRight($user->id);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function updateRightsByRoleId($role_id) {
        $role = Role::find($role_id);

        $role->users()->chunkById(100, function ($users) {
            foreach ($users as $user) {
                $this->updateRight($user->id);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        User::destroy($id);
    }

    /**
     * {@inheritdoc}
     */
    public function checkRight($right)
    {
        if (Auth::check()) {
            $rights = config('rbac.rights');
            $val = Arr::get($rights, $right);
            return Auth::user()->right & $val;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function authorize($right)
    {
        abort_if(!$this->checkRight($right), 403);
    }
}