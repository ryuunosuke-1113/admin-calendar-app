<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * カレンダー画面表示
     */
    public function calendar()
    {
        return view('admin.calendar');
    }

    /**
     * 予定一覧（FullCalendar 用 JSON）
     * start / end クエリ対応
     */
    public function index(Request $request)
    {
        $query = Event::query()
            ->where('user_id', auth()->id());

        // FullCalendar から渡される start / end に対応
        if ($request->filled('start')) {
            $query->where('start_at', '>=', $request->input('start'));
        }

        if ($request->filled('end')) {
            $query->where('end_at', '<=', $request->input('end'));
        }

        $events = $query
            ->orderBy('start_at')
            ->get();

        return response()->json(
            $events->map(fn ($e) => [
                'id'      => $e->id,
                'title'   => $e->title,
                'start'   => $e->start_at, // toISOString() は使わない
                'end'     => $e->end_at,
                'allDay'  => (bool) $e->all_day,
                'notes'   => $e->notes,
            ])
        );
    }

    /**
     * 予定追加
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'    => ['required', 'string', 'max:100'],
            'start_at' => ['required', 'date'],
            'end_at'   => ['nullable', 'date'],
            'all_day'  => ['nullable', 'boolean'],
            'notes'    => ['nullable', 'string'],
        ]);

        $event = Event::create([
            'user_id'  => auth()->id(),
            'title'    => $data['title'],
            'start_at' => $data['start_at'],
            'end_at'   => $data['end_at'] ?? $data['start_at'],
            'all_day'  => $data['all_day'] ?? false,
            'notes'    => $data['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'created',
            'event' => [
                'id'     => $event->id,
                'title'  => $event->title,
                'start'  => $event->start_at,
                'end'    => $event->end_at,
                'allDay' => (bool) $event->all_day,
            ],
        ], 201);
    }
public function update(Request $request, Event $event)
{
    abort_unless($event->user_id === auth()->id(), 403);

    $data = $request->validate([
        'title' => ['required', 'string', 'max:100'],
        'notes' => ['nullable', 'string'],
        'start_at' => ['nullable', 'date'],
        'end_at' => ['nullable', 'date'],
        'all_day' => ['nullable', 'boolean'],
    ]);

    // 今回はまずタイトルだけでもOK。送られてきたものだけ更新する
    $event->update(array_filter([
        'title' => $data['title'] ?? null,
        'notes' => $data['notes'] ?? null,
        'start_at' => $data['start_at'] ?? null,
        'end_at' => $data['end_at'] ?? null,
        'all_day' => $data['all_day'] ?? null,
    ], fn($v) => $v !== null));

    return response()->json(['message' => 'updated']);
}

public function destroy(Event $event)
{
    abort_unless($event->user_id === auth()->id(), 403);

    $event->delete();

    return response()->json(['message' => 'deleted']);
}

    /**
     * 予定更新（タイトル編集など）
     */
}
