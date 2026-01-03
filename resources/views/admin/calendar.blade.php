@extends('layouts.admin')

@section('content')
  <h1>Calendar</h1>

  <div id="calendar"></div>

  {{-- ===== 詳細モーダル ===== --}}
  <div id="eventModalOverlay"
       style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:9999;">

    <div style="max-width:520px; margin:80px auto; background:#fff; border-radius:12px; padding:16px;">
      <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
        <h2 style="margin:0; font-size:18px;">予定の詳細</h2>
        <button type="button" id="eventModalCloseBtn"
                style="border:none; background:#eee; padding:6px 10px; cursor:pointer;">
          ✕
        </button>
      </div>

      <div style="margin-top:12px; display:grid; gap:10px;">
        <div>
          <div style="font-size:12px; color:#666;">タイトル</div>
          <input id="modalTitle" type="text"
                 style="width:100%; padding:8px; border:1px solid #ddd; border-radius:8px;" disabled>
        </div>

        <div>
          <div style="font-size:12px; color:#666;">開始</div>
          <div id="modalStart" style="padding:8px; background:#f7f7f7; border-radius:8px;"></div>
        </div>

        <div>
          <div style="font-size:12px; color:#666;">終了</div>
          <div id="modalEnd" style="padding:8px; background:#f7f7f7; border-radius:8px;"></div>
        </div>

        <div>
          <div style="font-size:12px; color:#666;">終日</div>
          <div id="modalAllDay" style="padding:8px; background:#f7f7f7; border-radius:8px;"></div>
        </div>

        <div>
          <div style="font-size:12px; color:#666;">メモ</div>
          <textarea id="modalNotes" rows="4"
                    style="width:100%; padding:8px; border:1px solid #ddd; border-radius:8px;" disabled></textarea>
        </div>
      </div>

      <div style="margin-top:14px; display:flex; gap:10px; justify-content:flex-end;">
        <button type="button" id="editBtn"
                style="border:none; background:#1976d2; color:#fff; padding:8px 12px; border-radius:8px; cursor:pointer;">
          編集
        </button>

        <button type="button" id="saveBtn"
                style="display:none; border:none; background:#2e7d32; color:#fff; padding:8px 12px; border-radius:8px; cursor:pointer;">
          保存
        </button>

        <button type="button" id="cancelEditBtn"
                style="display:none; border:none; background:#999; color:#fff; padding:8px 12px; border-radius:8px; cursor:pointer;">
          キャンセル
        </button>

        <button type="button" id="deleteBtn"
                style="border:none; background:#d32f2f; color:#fff; padding:8px 12px; border-radius:8px; cursor:pointer;">
          削除
        </button>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/admin-calendar.js')
@endpush
