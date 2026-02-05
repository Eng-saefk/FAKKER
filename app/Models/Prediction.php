<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'predicted_winner',
        'is_correct',
    ];

    // علاقة تربط التوقع بالمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة تربط التوقع بالمباراة
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}