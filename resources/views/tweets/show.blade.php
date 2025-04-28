@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
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
                <img src="{{ asset('storage/' . $tweet->image_path) }}" 
                     alt="添付画像" 
                     class="img-fluid rounded">
            @endif

            <!-- 投稿日時 -->
            <p class="text-muted mt-3">{{ $tweet->created_at->format('Y年m月d日 H:i') }}</p>

            <!-- 編集・削除（自分の投稿の場合） -->
            @auth
                @if(auth()->user()->id == $tweet->user_id)
                    <div class="mt-2">
                        <a href="{{ route('tweets.edit', $tweet->id) }}" class="btn btn-warning btn-sm">編集</a>
                        <form action="{{ route('tweets.destroy', $tweet->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">削除</button>
                        </form>
                    </div>
                @endif
            @endauth

            <!-- いいねボタン -->
            @auth
            <form action="{{ route('likes.store', $tweet->id) }}" method="POST" class="like-form" id="like-form-{{ $tweet->id }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    @if ($tweet->likes->where('user_id', Auth::id())->isEmpty())
                        いいね ({{ $tweet->likes->count() }})
                    @else
                        いいね済み ({{ $tweet->likes->count() }})
                    @endif
                </button>
            </form>
            @endauth

            <!-- コメントセクション -->
            <div class="mt-3">
                <h5>コメント</h5>
                @foreach ($tweet->comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body">
                            <h6>{{ $comment->user->name }}:</h6>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                @endforeach

                @auth
                    <form action="{{ route('comments.store', $tweet->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment_content" class="form-control" rows="2" placeholder="コメントを追加"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">コメントする</button>
                    </form>
                @endauth
            </div>

            <!-- リツイート -->
            @auth
                <form action="{{ route('retweets.create', $tweet->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-info btn-sm">リツイート</button>
                </form>
            @endauth
        </div>
    </div>

    <!-- 戻るボタン -->
    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">戻る</a>
</div>

<!-- いいねモーダル（ポップアップ） -->
<div class="modal fade" id="likeModal" tabindex="-1" aria-labelledby="likeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="likeModalLabel">いいねをしました</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        このツイートに「いいね」をしました。
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // いいねボタンがクリックされたとき
        $('.like-form').on('submit', function(e) {
            e.preventDefault(); // フォームのデフォルト動作をキャンセル

            var form = $(this);
            var url = form.attr('action'); // いいねのURL
            var button = form.find('button'); // いいねボタン

            // 送信する前にボタンを無効にしておく（ダブルクリック防止）
            button.prop('disabled', true);

            $.ajax({
                url: url,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    // ボタンを有効に戻す
                    button.prop('disabled', false);

                    // ボタンのテキストといいね数を更新
                    if (response.like_count !== undefined) {
                        // いいね数とボタンテキストを更新
                        button.html(response.liked ? 'いいね済み (' + response.like_count + ')' : 'いいね (' + response.like_count + ')');
                    }
                },
                error: function(xhr, status, error) {
                    // エラーハンドリング
                    button.prop('disabled', false);
                    alert('いいねの処理中にエラーが発生しました。');
                }
            });
        });
    });

    function showLikeModal(event) {
        event.preventDefault();  // フォームの送信を防ぐ
        // モーダルを表示
        var myModal = new bootstrap.Modal(document.getElementById('likeModal'));
        myModal.show();
        
        // フォームの送信を実行
        event.target.submit();
    }
</script>
@endpush
