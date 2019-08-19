<?php

namespace App\Repositories;

use App\Site;
use App\Contracts\Repositories\SiteRepository as Contract;
use Carbon\Carbon;

class SiteRepository implements Contract
{

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
    public function find($id)
    {
        return Site::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $site = Site::create($data);

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
