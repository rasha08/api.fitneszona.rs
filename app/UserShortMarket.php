<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class UserShortMarket extends Model
{
    use SyncsWithFirebase;

    protected $table = 'usersfb';
}
