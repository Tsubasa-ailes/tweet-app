@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ツイート編集</h1>

    <form action="{{ route('tweets.update', $tweet->id) }}" method="POST enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="image" class="form-label">画像を変更</label>
            <input type="file" name="image" class="form-control" id="image">
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <textarea name="content" class="form-control" rows="3">{{ old('content', $tweet->content) }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" onclick="return confirm('本当に更新しますか？')">更新する</button>
    </form>

    <a href="{{ route('tweets.show', $tweet->id) }}" class="btn btn-secondary mt-3">戻る</a>
</div>
@endsection
