@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ツイート作成</h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form action="{{ route('tweets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="content" class="form-label">内容</label>
            <textarea name="content" id="content" class="form-control" rows="3" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">画像（任意）</label>
            <input type="file" name="image_path" id="image_path" class="form-control">
            @error('image_path')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">投稿</button>
    </form>
</div>
@endsection
