<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class point extends Model
{
    //
    protected $fillable = ['user_key','date','total_valid_bet_amount', 'point', 'last_point'];
}
