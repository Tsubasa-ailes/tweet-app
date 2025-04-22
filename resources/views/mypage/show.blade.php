@extends('layouts.app')

@section('content')
<div class="container">
    <h2>マイページ</h2>

    {{-- プロフィール画像 --}}
    @if ($user->profile_image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="プロフィール画像" style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%;">
        </div>
    @else
        <p>プロフィール画像は未設定です。</p>
    @endif

    {{-- プロフィール編集フォーム --}}
    <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- 名前 --}}
        <div class="mb-3">
            <label for="name" class="form-label">名前</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
        </div>

        {{-- メールアドレス --}}
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
        </div>

        {{-- パスワード（任意変更） --}}
        <div class="mb-3">
            <label for="password" class="form-label">新しいパスワード（変更しない場合は空のままで）</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        {{-- プロフィール画像 --}}
        <div class="mb-3">
            <label for="profile_image" class="form-label">プロフィール画像</label>
            <input type="file" name="profile_image" id="profile_image" class="form-control">
        </div>

        {{-- 紹介文 --}}
        <div class="mb-3">
            <label for="about" class="form-label">紹介文</label>
            <textarea name="about" id="about" class="form-control" rows="3">{{ old('about', $user->about) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
    </form>
</div>
@endsection
