<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function store(Post $post)
    {
        $userId = auth()->id();

        $like = $post->likes()->where('user_id', $userId)->first();

        if ($like) {
            // いいねしてたら取り消す
            $like->delete();
            return back()->with('message', 'いいねを取り消しました');
        } else {
            // いいねしてなければ追加
            $post->likes()->create([
                'user_id' => $userId,
            ]);
            return back()->with('message', 'いいねしました');
        }
    }
}
