<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name',
    ];

    public function siteUrls()
    {
        return $this->hasMany('App\SiteUrl');
    }
}
