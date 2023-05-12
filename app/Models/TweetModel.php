<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TweetModel extends Model
{
    use HasFactory;

    protected $table = 'tweet';
    protected $fillable = [
        'tweet'
    ];
}
