<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Site extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'user_id'
    ];

    public function siteUrls()
    {
        return $this->hasMany('App\SiteUrl')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
