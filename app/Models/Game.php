<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'team_a',
        'team_b',
        'game_time',
        'status',
        'result',
        'points_win',
    ];
}