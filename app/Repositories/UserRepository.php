<?php

namespace App\Repositories;

use App\User;
use App\Role;
use App\Contracts\Repositories\UserRepository as Contract;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UserRepository implements Contract
{
    protected $rights, $cachePrefix, $cacheSeconds;

    public function __construct()
    {
        $this->rights = config('rbac.rights');
        $this->cachePrefix = "user.cache.";
        $this->cacheSeconds = 600;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getUsers($key)
    {
        $query = User::where(function($query) use($key) {
            $query->where('first_name', 'LIKE', "%{$key}%")->orWhere('last_name', 'LIKE', "%{$key}%")->orWhere('email', 'LIKE', "%{$key}%");
        });
        return paginate($query, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersByRoleId($role_id, $key)
    {
        $role = Role::where(['id', $role_id]);
        
        return $this->getUsersByRole($role, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersByRole(Role $role, $key)
    {
        $query = $role->users()->where(function($query) use($key) {
            $query->where('first_name', 'LIKE', "%{$key}%")->orWhere('last_name', 'LIKE', "%{$key}%")->orWhere('email', 'LIKE', "%{$key}%");
        });

        return paginate($query, $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getRight() {

        $user = user();

        return $this->getRightByUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getRightByUserId($id) {

        $user = User::find($id);

        return $this->getRightByUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getRightByUser(User $user) {
        $right = 0;

        $roles = $user->roles()->get();

        foreach($roles as $role) {
            $right = $right | $role->right;
        }

        return $right | $user->right;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigRights() {
        $rights = config('rbac.rights');

        $arr = array();

        foreach ($rights as $obj=>$right) {
            
            foreach($right as $key=>$val) {
                $cat = app()->make('stdClass');
                $cat->name = "$obj.$key";
                $cat->value = $val;
                $arr[] = $cat;
            }
        }

        return $arr;
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
            $password = Str::random(10);
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
        User::where('id', $id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateProfile(array $data)
    {
        $this->update(user_id(), $data);
    }

    public function updatePassword($password)
    {
        $data = [
            'password' => Hash::make($password),
        ];
        
        $this->update(user_id(), $data);
    }

    /**
     * {@inheritdoc}
     */
    public function clearRightByRoleId($role_id) {

        $role = Role::find($role_id);

        $role->users()->chunkById(64, function ($users) {
            foreach ($users as $user) {
                $cacheKey = $this->cachePrefix . "." . $user->id;
                Cache::forget($cacheKey);
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

            $user = user();

            $cacheKey = $this->cachePrefix . "." . $user->id;

            $userRight = Cache::remember($cacheKey, $this->cacheSeconds, function () use ($user) {
                return $this->getRightByUser($user);
            });
            
            $val = Arr::get($this->rights, $right);
            return $userRight & $val;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function checkRights($rights)
    {
        if(is_array($rights)) {
            $rval = true;

            foreach($rights as $right) {

                if(!$this->checkRight($right)) {
                    $rval = false;
                    break;
                }
            }

            return $rval;
            
        } else {
            $rights = explode('|', $rights);

            $rval = false;

            foreach($rights as $right) {

                if($this->checkRight($right)) {
                    $rval = true;
                    break;
                }
            }

            return $rval;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function authorize($rights)
    {
        abort_if(!$this->checkRights($rights), 403);
    }
}