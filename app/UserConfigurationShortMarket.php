<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class UserConfigurationShortMarket extends Model
{
    use SyncsWithFirebase;
    
    protected $table = 'userconfigurationfb';
}
