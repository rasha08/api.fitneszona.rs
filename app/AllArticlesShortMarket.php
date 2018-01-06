<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class AllArticlesShortMarket extends Model
{
    use SyncsWithFirebase;

    protected $table = 'all_articles_fb';
}
