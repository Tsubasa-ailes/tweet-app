<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'image_path',
        'is_deleted',
    ];

    protected $casts = [
        'is_deleted' => 'integer',
    ];

    // ツイートの所有者（1対多の逆）
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
