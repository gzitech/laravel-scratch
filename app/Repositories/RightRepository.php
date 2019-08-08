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
                $cat->name = "$obj.$key";
                $cat->value = $val;
                $arr[] = $cat;
            }
        }

        return $arr;
    }
}
