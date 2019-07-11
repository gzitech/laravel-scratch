<?php

namespace App\Repositories;

use App\User;
use App\Contracts\Repositories\UserRepository as Contract;
use Carbon\Carbon;

class UserRepository implements Contract
{

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
        $user = User::create($data);

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
    public function destroy($id)
    {
        User::destroy($id);
    }
}