<?php

namespace App\Repositories;

use App\Contracts\Repositories\RightRepository as Contract;
use Carbon\Carbon;

class RightRepository implements Contract
{
    public function all() {
        $rights = config('rbac.rights');

        $arr = array();

        foreach ($rights as $obj=>$right) {
            
            foreach($right as $key=>$val) {
                $cat = app()->make('stdClass');
                $cat->right_name = "$obj.$key";
                $cat->right_value = $val;
                $arr[] = $cat;
            }
        }

        return $arr;
    }
}
