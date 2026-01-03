@extends('layouts.admin')

@section('title', 'お知らせ管理')
@section('h1', 'お知らせ管理')

@section('content')
  @if(session('status'))
    <div class="mb-4 rounded bg-green-50 border border-green-200 p-3 text-green-800">
      {{ session('status') }}
    </div>
  @endif

  <div class="flex items-center justify-between mb-4">
    <p class="text-sm text-gray-600">登録済み：{{ $items->total() }}件</p>

    <a href="{{ route('admin.news.create') }}"
       class="px-3 py-2 rounded bg-blue-600 text-white text-sm hover:bg-blue-700">
      新規作成
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="text-left border-b">
          <th class="py-2">ID</th>
          <th class="py-2">タイトル</th>
          <th class="py-2">更新日</th>
          <th class="py-2 w-40">操作</th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $item)
          <tr class="border-b">
            <td class="py-2">{{ $item->id }}</td>
            <td class="py-2">{{ $item->importance }}</td>
            <td class="py-2 font-medium">
  <a href="{{ route('admin.news.show', $item) }}" class="text-blue-700 hover:underline">
    {{ $item->title }}
  </a>
</td>
            <td class="py-2">{{ $item->updated_at->format('Y-m-d') }}</td>
            <td class="py-2">
              <div class="flex gap-2">
                <a class="text-blue-600 hover:underline"
                   href="{{ route('admin.news.edit', $item) }}">編集</a>

                <form method="POST" action="{{ route('admin.news.destroy', $item) }}"
                      onsubmit="return confirm('削除しますか？');">
                  @csrf
                  @method('DELETE')
                  <button class="text-red-600 hover:underline" type="submit">削除</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td class="py-4 text-gray-600" colspan="4">まだありません。新規作成してください。</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $items->links() }}
  </div>
@endsection
