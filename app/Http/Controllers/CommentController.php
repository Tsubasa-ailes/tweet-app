<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tweet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $tweetId)
    {
        $request->validate([
            'comment_content' => 'required|string|max:255',
        ]);

        $tweet = Tweet::findOrFail($tweetId);

        $tweet->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->comment_content,
        ]);

        return redirect()->route('tweets.show', $tweetId);
    }
}
