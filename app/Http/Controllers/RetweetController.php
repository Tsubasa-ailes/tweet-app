<?php

namespace App\Http\Controllers;

use App\Models\Retweet;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetweetController extends Controller
{
    public function store(Request $request, $tweetId)
    {
        // ツイートを取得
        $tweet = Tweet::findOrFail($tweetId);

        // リツイートを作成
        $retweet = new Retweet();
        $retweet->user_id = Auth::id();
        $retweet->tweet_id = $tweet->id;
        $retweet->save();

        // ツイート詳細ページにリダイレクト
        return redirect()->route('tweets.show', $tweetId);
    }
}
