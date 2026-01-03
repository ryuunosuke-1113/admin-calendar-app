@extends('layouts.admin')

@section('title', 'お知らせ作成')
@section('h1', 'お知らせ作成')

@section('content')
<form method="POST" action="{{ route('admin.news.store') }}" class="space-y-4">
  @csrf

  <div>
    <label class="block text-sm font-medium mb-1">タイトル</label>
    <div>
  <label class="block text-sm font-medium mb-1">重要度</label>
  <select name="importance" class="w-full rounded border-gray-300">
    @for($i = 1; $i <= 5; $i++)
      <option value="{{ $i }}" @selected(old('importance', 3) == $i)>
        {{ $i }}
      </option>
    @endfor
  </select>

  @error('importance')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
  @enderror
</div>

    <input name="title" value="{{ old('title') }}"
           class="w-full rounded border-gray-300" />
  </div>

  <div>
    <label class="block text-sm font-medium mb-1">本文</label>
    <textarea name="body" rows="6"
              class="w-full rounded border-gray-300">{{ old('body') }}</textarea>
  </div>

  <div class="flex gap-2">
    <button type="submit"
            class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
      保存
    </button>

    <a href="{{ route('admin.news.index') }}"
       class="px-4 py-2 rounded border">
      戻る
    </a>
  </div>
</form>
@endsection
