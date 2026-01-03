<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'news_id',
        'user_id',
        'parent_id',
        'body',
    ];

    /**
     * このコメントが属するお知らせ
     */
    public function news()
    {
        return $this->belongsTo(News::class);
    }

    /**
     * このコメントを書いたユーザー
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * このコメントへの返信一覧
     * （parent_id が自分の id のもの）
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->orderBy('created_at');
    }

    /**
     * このコメントの親コメント
     * （返信の場合のみ）
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}
