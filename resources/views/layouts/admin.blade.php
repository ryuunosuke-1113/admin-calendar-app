<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>管理画面</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body style="margin:0; font-family: sans-serif; background:#f5f5f5;">

  {{-- ===== 管理画面ヘッダー ===== --}}
  <header style="background:#222; color:#fff; padding:12px 20px;">
    <nav style="display:flex; align-items:center; gap:16px;">
      <strong style="margin-right:24px;">管理画面</strong>

      <a href="{{ route('admin.index') }}"
         style="color:#fff; text-decoration:none;">
        トップ
      </a>

      <a href="{{ route('admin.news.index') }}"
         style="color:#fff; text-decoration:none;
         {{ request()->routeIs('admin.news.*') ? 'font-weight:bold; text-decoration:underline;' : '' }}">
        お知らせ
      </a>

      <a href="{{ route('admin.calendar') }}"
         style="color:#fff; text-decoration:none;
         {{ request()->routeIs('admin.calendar') ? 'font-weight:bold; text-decoration:underline;' : '' }}">
        カレンダー
      </a>

      {{-- 右寄せ --}}
      <div style="margin-left:auto;">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  style="background:#444; color:#fff; border:none; padding:6px 12px; cursor:pointer;">
            ログアウト
          </button>
        </form>
      </div>
    </nav>
  </header>

  {{-- ===== メインコンテンツ ===== --}}
  <main style="padding:24px;">
    @yield('content')
  </main>

  {{-- JS読み込み用 --}}
  @stack('scripts')
</body>
</html>
