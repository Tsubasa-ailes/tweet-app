<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // ここに user_id を追加
    protected $fillable = ['tweet_id', 'user_id'];

    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
