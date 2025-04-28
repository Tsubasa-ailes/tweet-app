@extends('layouts.app')

@section('content')
<div class="container">
    <h1>ツイート一覧</h1>

    <!-- ツイート一覧 -->
    <div class="tweets">
        @foreach ($tweets as $tweet)
            <div class="card mb-3 tweet-card" data-tweet-id="{{ $tweet->id }}" style="cursor: pointer;">
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

                    <!-- いいねボタン -->
                    <div class="mt-3">
                        <form action="#" method="POST" class="like-form" data-tweet-id="{{ $tweet->id }}">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm like-btn">
                                <i class="fas fa-heart {{ $tweet->likes()->where('user_id', auth()->id())->exists() ? 'text-danger' : '' }}"></i> 
                                いいね (<span class="like-count">{{ $tweet->likes->count() }}</span>)
                            </button>
                        </form>
                    </div>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // いいねボタンがクリックされた時
        document.querySelectorAll('.like-form').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation(); // クリックイベントの伝播を停止

                const tweetId = this.dataset.tweetId;
                const formData = new FormData(this);

                // Ajaxリクエストを送信
                fetch(`/tweets/${tweetId}/like`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.liked !== undefined) {
                        const likeBtn = this.querySelector('.like-btn');
                        const likeCount = likeBtn.querySelector('.like-count');
                        const heartIcon = likeBtn.querySelector('i');
                        
                        // いいねボタンの状態を変更
                        heartIcon.classList.toggle('text-danger', data.liked);
                        
                        // いいね数を更新
                        likeCount.textContent = data.like_count;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });

        // ツイートカードをクリックした際に詳細ページに遷移
        document.querySelectorAll('.tweet-card').forEach(card => {
            card.addEventListener('click', function(event) {
                if (!event.target.closest('.like-btn')) {  // いいねボタン以外でクリックした場合
                    window.location.href = `{{ url('tweets') }}/${this.dataset.tweetId}`;
                }
            });
        });
    });
</script>
@endpush
@endsection
