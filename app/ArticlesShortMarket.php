<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;


class ArticlesShortMarket extends Model
{
    use SyncsWithFirebase;

    protected $table = 'articlesfb';
    protected $fillable = ['id', 'update', 'created_at', 'updated_at'];

}
