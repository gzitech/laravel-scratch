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
        return $this->find(Auth::id());
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
    public function getUsers($key)
    {
        $query = User::where(function($query) use($key) {
            $query->where('first_name', 'LIKE', "%{$key}%")->orWhere('last_name', 'LIKE', "%{$key}%")->orWhere('email', 'LIKE', "%{$key}%");
        });

        return $this->paginate($query);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersBySiteId($site_id, $key)
    {
        $query = Site::find($site_id)->users()->where(function($query) use($key) {
            $query->where('first_name', 'LIKE', "%{$key}%")->orWhere('last_name', 'LIKE', "%{$key}%")->orWhere('email', 'LIKE', "%{$key}%");
        });

        return $this->paginate($query);
    }

    /**
     * {@inheritdoc}
     */
    public function getUsersByRoleId($role_id)
    {
        return $this->paginate(Role::find($role_id)->users());
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

    public function getRights() {
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

    public function clearRightByRoleId($role_id) {

        $site = $this->site();

        $role = Role::find($role_id);

        $role->users()->chunkById(64, function ($users) use($site) {
            foreach ($users as $user) {
                $cacheKey = config('site.cache_site_user_right_key') . $site->id . "_" . $user->id;
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
        abort_if(!$this->checkRights($right), 403);
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