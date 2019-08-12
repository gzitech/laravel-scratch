<?php

namespace App\Repositories;

use App\SettingProfile;
use App\Contracts\Repositories\SettingProfileRepository as Contract;
use Carbon\Carbon;

class SettingProfileRepository implements Contract
{

    /**
     * {@inheritdoc}
     */
    public function paginate()
    {
        if(config('app.paginate_type') == 'paginate') {
            return SettingProfile::paginate(config("app.max_page_size"));
        } else {
            return SettingProfile::simplePaginate(config("app.max_page_size"));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        return SettingProfile::find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        $setting_profile = SettingProfile::create($data);

        return $setting_profile;
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        SettingProfile::where('id', $id)->update($data);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($id)
    {
        SettingProfile::destroy($id);
    }
}
