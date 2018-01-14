<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class userArticlesFb extends Model
{
    use SyncsWithFirebase;

    protected $table = 'user_articles_fb';
}
