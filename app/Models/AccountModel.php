<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountModel extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $fillable = [
        'birth_day',
        'name',
        'password',
        'tel',
        'address1',
        'address2',
        'introduction',
        'upload_image_name',
        'login_status'
    ];
}
