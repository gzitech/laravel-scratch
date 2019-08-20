<?php

namespace App\Repositories;

use App\SiteUrl;
use App\Contracts\Repositories\SiteUrlRepository as Contract;
use Carbon\Carbon;

class SiteUrlRepository implements Contract
{

    /**
     * {@inheritdoc}
     */
    public function getSiteUrls()
    {
        if(config('app.paginate_type') == 'paginate') {
            return SiteUrl::paginate(config("app.max_page_size"));
        } else {
            return SiteUrl::simplePaginate(config("app.max_page_size"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return SiteUrl::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $site_url = SiteUrl::create($data);

        return $site_url;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        SiteUrl::where('id', $id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        SiteUrl::destroy($id);
    }
}
