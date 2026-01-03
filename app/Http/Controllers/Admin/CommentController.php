<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // コメント（誰でも投稿OK）
    public function store(Request $request, News $news)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Comment::create([
            'news_id' => $news->id,
            'user_id' => auth()->id(),
            'parent_id' => null,
            'body' => $data['body'],
        ]);

        return back()->with('status', 'コメントしました');
    }

    // 返信（お知らせ作成者だけ）
    public function reply(Request $request, News $news, Comment $comment)
    {
        // scopeBindings() を付けていれば comment は news 配下のものに限定されますが、念のため親チェック
        if ($comment->news_id !== $news->id) {
            abort(404);
        }

        // 返信できるのは「お知らせの作成者」だけ（※必要に応じて変更可）
        if ($news->user_id !== auth()->id()) {
            abort(403);
        }

        $data = $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Comment::create([
            'news_id' => $news->id,
            'user_id' => auth()->id(),
            'parent_id' => $comment->id,
            'body' => $data['body'],
        ]);

        return back()->with('status', '返信しました');
    }
}

