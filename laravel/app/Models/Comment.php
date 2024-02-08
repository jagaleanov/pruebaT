<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'article_id',
        'user_id',
        'content',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

