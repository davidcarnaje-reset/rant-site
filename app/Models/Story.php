<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    // Pinapayagan nating lagyan ng laman ang mga columns na ito
    protected $fillable = ['title', 'slug', 'content', 'option_a', 'option_b', 'image_path'];

    // Relasyon: Ang isang kwento ay may maraming boto
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Relasyon: Ang isang kwento ay may maraming komento
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}