@extends('layouts.admin')

@section('title', 'お知らせ詳細')
@section('h1', 'お知らせ詳細')

@section('content')
  <div class="space-y-3">
    <div>
      <div class="text-sm text-gray-500">タイトル</div>
      <div class="text-lg font-semibold">{{ $news->title }}</div>
    </div>

    <div>
      <div class="text-sm text-gray-500">本文</div>
      <div class="whitespace-pre-wrap text-gray-800">{{ $news->body }}</div>
    </div>

    <hr class="my-6">

<h2 class="text-lg font-bold mb-3">コメント</h2>

{{-- コメント投稿（誰でも） --}}
<form method="POST" action="{{ route('admin.news.comments.store', $news) }}" class="space-y-2 mb-6">
  @csrf
  <textarea name="body" rows="3" class="w-full rounded border-gray-300"
            placeholder="コメントを書く...">{{ old('body') }}</textarea>
  @error('body') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
  <button class="px-4 py-2 rounded bg-gray-900 text-white">コメント送信</button>
</form>

{{-- コメント一覧 --}}
<div class="space-y-4">
  @forelse($news->comments as $c)
    <div class="border rounded p-4 bg-white">
      <div class="text-sm text-gray-600 mb-2">
        {{ $c->user->email }} ・ {{ $c->created_at->format('Y-m-d H:i') }}
      </div>
      <div class="whitespace-pre-wrap">{{ $c->body }}</div>

      {{-- 返信表示 --}}
      @if($c->replies->count())
        <div class="mt-4 space-y-3 pl-4 border-l">
          @foreach($c->replies as $r)
            <div>
              <div class="text-sm text-gray-600 mb-1">
                返信：{{ $r->user->email }} ・ {{ $r->created_at->format('Y-m-d H:i') }}
              </div>
              <div class="whitespace-pre-wrap">{{ $r->body }}</div>
            </div>
          @endforeach
        </div>
      @endif

      {{-- 返信フォーム（お知らせ作成者だけ） --}}
      @if($news->user_id === auth()->id())
        <form method="POST" action="{{ route('admin.news.comments.reply', [$news, $c]) }}" class="mt-4 space-y-2">
          @csrf
          <textarea name="body" rows="2" class="w-full rounded border-gray-300"
                    placeholder="このコメントに返信..."></textarea>
          <button class="px-3 py-2 rounded bg-blue-600 text-white">返信</button>
        </form>
      @endif
    </div>
  @empty
    <p class="text-gray-600">まだコメントはありません。</p>
  @endforelse
</div>


    <div>
  <div class="text-sm text-gray-500">重要度</div>
  <div class="font-semibold">{{ $news->importance }}</div>
</div>


    <div class="text-sm text-gray-500">
      作成: {{ $news->created_at->format('Y-m-d H:i') }}
      / 更新: {{ $news->updated_at->format('Y-m-d H:i') }}
    </div>

    <div class="pt-2 flex gap-2">
      <a href="{{ route('admin.news.edit', $news) }}"
         class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
        編集
      </a>

      <a href="{{ route('admin.news.index') }}"
         class="px-4 py-2 rounded border">
        一覧へ戻る
      </a>

      <form method="POST" action="{{ route('admin.news.destroy', $news) }}"
            onsubmit="return confirm('削除しますか？');">
        @csrf
        @method('DELETE')
        <button class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
          削除
        </button>
      </form>
    </div>
  </div>
@endsection
