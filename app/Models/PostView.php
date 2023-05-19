<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostView extends Model
{
    use HasFactory;

    protected $table = 'post_view';

    protected $fillable = ['post_id', 'views'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
