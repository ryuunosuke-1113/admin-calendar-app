@extends('layouts.admin')

@section('title', 'お知らせ編集')
@section('h1', 'お知らせ編集')

@section('content')
  <form method="POST" action="{{ route('admin.news.update', $news) }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium mb-1">タイトル</label>
      <div>
  <label class="block text-sm font-medium mb-1">重要度</label>
  <select name="importance" class="w-full rounded border-gray-300">
    @for($i = 1; $i <= 5; $i++)
      <option value="{{ $i }}" @selected(old('importance', $news->importance) == $i)>
        {{ $i }}
      </option>
    @endfor
  </select>

  @error('importance')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

      <input name="title" value="{{ old('title', $news->title) }}"
             class="w-full rounded border-gray-300" />
      @error('title')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">本文</label>
      <textarea name="body" rows="6"
                class="w-full rounded border-gray-300">{{ old('body', $news->body) }}</textarea>
      @error('body')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
      @enderror
    </div>

    <div class="flex gap-2">
      <button class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">更新</button>
      <a href="{{ route('admin.news.index') }}" class="px-4 py-2 rounded border">戻る</a>
    </div>
  </form>
@endsection
