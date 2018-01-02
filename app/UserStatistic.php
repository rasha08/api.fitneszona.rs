<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatistic extends Model
{
    protected $table = 'users_statistic';

    public function setAtribute($atribute, $value)
    {
        $this->attributes[$atribute] = json_encode($value);
    }

    public function getAtribute($atribute)
    {
        return $this->attributes[$atribute];
    }
}
