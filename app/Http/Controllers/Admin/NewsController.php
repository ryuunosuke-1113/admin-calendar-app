<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::latest()->paginate(10);
        return view('admin.news.index', compact('items'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body'  => ['nullable', 'string'],
            'importance' => ['required', 'integer', 'between:1,5'],
        ]);

        News::create($data + ['user_id' => auth()->id()]);


        return redirect()->route('admin.news.index')->with('status', '作成しました');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body'  => ['nullable', 'string'],
            'importance' => ['required', 'integer', 'between:1,5'],
        ]);

        $news->update($data);

        return redirect()->route('admin.news.index')->with('status', '更新しました');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('admin.news.index')->with('status', '削除しました');
    }
public function show(News $news)
{
    $news->load([
        'user',
        'comments.user',
        'comments.replies.user',
    ]);

    return view('admin.news.show', compact('news'));
}


    
}
