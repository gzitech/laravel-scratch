<?php

namespace App\Repositories;

use App\Site;
use App\SiteUrl;
use App\User;
use App\Role;
use App\Contracts\Repositories\SiteRepository as Contract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SiteRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function site($site_id)
    {
        if ($site_id > 0) {
            return $this->find($site_id);
        } else {
            $site = new Site();
            $site->id = 0;
            $site->name = config('app.name');
            return $site;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSites($key)
    {
        return $this->paginate(Site::where('name', 'LIKE', "%{$key}%"), $key);
    }

    /**
     * {@inheritdoc}
     */
    public function getSitesByUserId($user_id, $key)
    {
        return $this->paginate(User::find($user_id)->sites()->where('name', 'LIKE', "%{$key}%"), $key);
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return Site::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function findByDomain($domain)
    {
        $data = [
            'domain'=>$domain,
        ];

        return SiteUrl::where($data)->first() ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {

        if(empty($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }

        $site = Site::create($data);

        $siteUrl = SiteUrl::create([
            'site_id' => $site->id,
            'domain' => $site->name . "." . config('site.default_domain'),
        ]);

        $site->users()->attach([
            $data['user_id']
        ]);

        $roles = config('rbac.sub_site_roles');

        foreach($roles as $key=>$role) {
            $role['site_id'] = $site->id;
            Role::create($role);
        }

        return $site;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        Site::where('id', $id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        Site::destroy($id);
    }

    /**
     * {@inheritdoc}
     */
    private function paginate($query, $key)
    {
        if(config('app.paginate_type') == 'paginate') {
            return $query->paginate(config("app.max_page_size"))->appends(['key' => $key]);
        } else {
            return $query->simplePaginate(config("app.max_page_size"))->appends(['key' => $key]);
        }
    }
}
