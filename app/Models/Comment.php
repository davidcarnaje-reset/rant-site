<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['story_id', 'username', 'comment_text', 'is_approved', 'ip_address'];

    // Relasyon: Ang isang komento ay pag-aari ng isang kwento
    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
