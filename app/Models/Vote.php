<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    // I-paste mo itong line sa ibaba:
    protected $fillable = ['story_id', 'choice', 'ip_address', 'user_agent'];
}
