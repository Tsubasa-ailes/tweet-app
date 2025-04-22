@extends('layouts.app')

@section('content')
<div class="container">
    <!-- @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('tweets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3" placeholder="いまどうしてる？">{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="file" name="image" class="form-control">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">ツイート</button>
    </form> -->

    <h1>ツイート一覧</h1>

    <!-- ツイート一覧 -->
    <div class="tweets">
        @foreach ($tweets as $tweet)
            <div class="card mb-3">
                <div class="card-body">
                    <!-- ユーザー名 -->
                    <h5 class="card-title">{{ $tweet->user->name }}</h5>

                    <!-- アイコンがあれば表示 -->
                    @if ($tweet->user->profile_image)
                        <img src="{{ asset('storage/' . $tweet->user->profile_image) }}" 
                             alt="ユーザーアイコン" 
                             class="rounded-circle mb-2" 
                             width="50" height="50">
                    @endif

                    <!-- ツイート内容 -->
                    <p class="card-text">{{ $tweet->content }}</p>

                    <!-- 画像がある場合 -->
                    @if ($tweet->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $tweet->image_path) }}" 
                                 alt="添付画像" 
                                 class="img-fluid rounded">
                        </div>
                    @endif

                    <!-- 投稿日時 -->
                    <small class="text-muted">{{ $tweet->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
<a href="{{ route('tweets.create') }}" 
   class="btn btn-primary rounded-circle position-fixed" 
   style="bottom: 30px; right: 30px; width: 60px; height: 60px; font-size: 30px; display: flex; align-items: center; justify-content: center; z-index: 1000;">
    +
</a>
@endsection
