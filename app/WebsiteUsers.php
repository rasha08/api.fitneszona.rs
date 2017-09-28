<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteUsers extends Model
{
    protected $table = 'website_users';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'email'
    ];
}
