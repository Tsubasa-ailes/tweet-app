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

    public function show($id)
    {
        $tweet = Tweet::with('user', 'comments.user', 'likes')->findOrFail($id);
        return view('tweets.show', compact('tweet'));
    }

    public function edit($id)
    {
        $tweet = Tweet::findOrFail($id);

        // 自分の投稿か確認
        if (auth()->user()->id !== $tweet->user_id) {
            return redirect()->route('tweets.index')->with('error', '権限がありません');
        }

        return view('tweets.edit', compact('tweet'));
    }

    public function update(Request $request, Tweet $tweet)
    {
        $request->validate([
            'content' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像バリデーションも追加！
        ]);
    
        $tweet->content = $request->content;
    
        // もし新しい画像がアップロードされたら
        if ($request->hasFile('image')) {
    
            // 古い画像があったら削除
            if ($tweet->image_path) {
                \Storage::delete('public/' . $tweet->image_path);
            }
    
            // 新しい画像を保存
            $path = $request->file('image_path')->store('image_path', 'public');
    
            // パスをDBに保存
            $tweet->image_path = $path;
        }
    
        $tweet->save();
    
        return redirect()->route('tweets.show', $tweet->id)->with('status', 'ツイートを更新しました！');
    }
    
    // 投稿削除
    public function destroy($id)
    {
        $tweet = Tweet::findOrFail($id);

        // 自分の投稿か確認
        if (auth()->user()->id !== $tweet->user_id) {
            return redirect()->route('tweets.index')->with('error', '権限がありません');
        }

        $tweet->delete();

        return redirect()->route('tweets.index')->with('success', '投稿が削除されました');
    }
}
