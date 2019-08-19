<?php

namespace App\Repositories;

use App\Site;
use App\SiteUrl;
use App\User;
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
            return new Site();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function paginate()
    {
        if(config('app.paginate_type') == 'paginate') {
            return Site::paginate(config("app.max_page_size"));
        } else {
            return Site::simplePaginate(config("app.max_page_size"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function paginateByUserId($user_id)
    {
        if(config('app.paginate_type') == 'paginate') {
            return User::find($user_id)->sites()->paginate(config("app.max_page_size"));
        } else {
            return User::find($user_id)->sites()->simplePaginate(config("app.max_page_size"));
        }
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

        return SiteUrl::where($data)->first()->site ?? null;
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

        $site->users()->attach([
            $data['user_id']
        ]);

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
}