<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['tweet_id', 'user_id'];
    
    public function tweet()
    {
        return $this->belongsTo(Tweet::class);
    }
}
