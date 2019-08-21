<?php

namespace App\Repositories;

use App\User;
use App\Role;
use App\Site;
use App\Contracts\Repositories\UserRepository as Contract;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UserRepository implements Contract
{
    protected $rights;

    public function __construct()
    {
        $this->rights = config('rbac.rights');
    }

    /**
     * {@inheritdoc}
     */
    public function id()
    {
        return Auth::id();
    }

    /**
     * {@inheritdoc}
     */
    public function user()
    {
        if (Auth::check()) {
            return $this->find(Auth::id());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function site()
    {
        return resolve('App\Site');
    }

    /**
     * {@inheritdoc}
     */
    public function getUsers()
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
    public function getUsersBySiteId($site_id)
    {
        if(config('app.paginate_type') == 'paginate') {
            return Site::find($site_id)->users()->paginate(config("app.max_page_size"));
        } else {
            return Site::find($site_id)->users()->simplePaginate(config("app.max_page_size"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersByRoleId($role_id)
    {
        if(config('app.paginate_type') == 'paginate') {
            return Role::find($role_id)->users()->paginate(config("app.max_page_size"));
        } else {
            return Role::find($role_id)->users()->simplePaginate(config("app.max_page_size"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRightById($id) {

        $user = User::find($id);

        return $this->getRight($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getRight(User $user) {
        $right = 0;
        
        $site = $this->site();

        $roles = $user->roles()->where('site_id', $site->id)->get();

        foreach($roles as $role) {
            $right = $right | $role->right;
        }

        return $right | $user->right;
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
    public function updateProfile(array $data)
    {
        User::find(Auth::id())->update($data);
    }

    public function updatePassword($password)
    {
        $user = User::find(Auth::id());
        $user->password = Hash::make($password);
        $user->save();
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

            $site = $this->site();
            $user = Auth::user();

            $cacheKey = config('site.cache_site_user_right_key') . $site->id . "_" . $user->id;

            $userRight = Cache::get($cacheKey, -1);

            if($userRight < 0) {
                $userRight = $this->getRight($user);
                Cache::put($cacheKey, $userRight, now()->addMinutes(12));
            }
            
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
    public function authorize($right)
    {
        abort_if(!$this->checkRight($right), 403);
    }
}