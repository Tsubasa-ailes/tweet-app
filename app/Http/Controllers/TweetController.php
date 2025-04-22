<?php

namespace App\Http\Controllers;

use App\Models\Tweet; 
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function create()
    {
        return view('tweets.create');
    }

    public function store(Request $request)
    {
        // バリデーションルール
        $validated = $request->validate([
            'content' => 'required|string|max:255',
            'image_path' => 'nullable|image|max:10240', // フォームの名前と一致させる
        ]);

        $tweet = new Tweet();
        $tweet->user_id = auth()->id();
        $tweet->content = $validated['content'];

        // 画像が存在する場合の処理
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('image_path', 'public'); // 'image_path' を使う
            $tweet->image_path = $path;
        }

        $tweet->save();

        return redirect()->back()->with('status', 'ツイートを投稿しました！');
    }
}
