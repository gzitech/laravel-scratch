<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id', 'role_name', 'role_description',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
