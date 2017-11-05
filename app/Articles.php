<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $table = 'articles';
    protected $hidden = ['likes_id', 'dislikes_id', 'comments_id'];
}
