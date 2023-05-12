<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendListModel extends Model
{
    use HasFactory;

    protected $table = 'friend_list';
    protected $fillable = [
        'request_flg',
        'approval_flg'
    ];
}
