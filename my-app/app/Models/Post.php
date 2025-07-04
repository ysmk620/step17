<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // 投稿が特定ユーザーにいいねされているかを確認する便利メソッド（オプション）
    public function isLikedBy(User $user): bool
    {
        return $this->likes->contains('user_id', $user->id);
    }
}
