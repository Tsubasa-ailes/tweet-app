<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    // LikesController.php

public function store($tweetId)
{
    $tweet = Tweet::findOrFail($tweetId);

    $user = auth()->user();

    // 既にいいねしてるか確認
    $like = $tweet->likes()->where('user_id', $user->id)->first();

    if ($like) {
        // いいね取り消し
        $like->delete();
        $liked = false;
    } else {
        // いいね追加
        $tweet->likes()->create([
            'user_id' => $user->id,
        ]);
        $liked = true;
    }

    $like_count = $tweet->likes()->count();

    // 【ここが重要】リクエストがAjaxならJSON返す
    if (request()->ajax()) {
        return response()->json([
            'liked' => $liked,
            'like_count' => $like_count,
        ]);
    }

    // そうじゃない場合はリダイレクト（通常のフォーム送信対策）
    return back();
}

}
