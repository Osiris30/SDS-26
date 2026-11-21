<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityEvidence extends Model
{
    protected $table = 'activity_evidences';

    protected $fillable = ['post_id', 'user_id', 'image_path', 'caption'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function contributor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
