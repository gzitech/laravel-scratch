<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteUrl extends Model
{
    protected $fillable = [
        'domain',
    ];

    public function site()
    {
        return $this->belongsTo('App\Site');
    }
}
