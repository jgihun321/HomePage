<?php

namespace App\Models\board;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'board_posts';

    protected $fillable = [
        'user_id',
        'title',
        'contents'
    ];

    const CREATED_AT = 'created_at';
}
