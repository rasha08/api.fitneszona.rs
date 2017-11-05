<?php

namespace App;

use Mpociot\Firebase\SyncsWithFirebase;
use Illuminate\Database\Eloquent\Model;

class ConfigurationShortMarket extends Model
{
    use SyncsWithFirebase;

    protected $table = 'configurationsfb';
}
