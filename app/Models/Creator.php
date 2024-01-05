<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Creator extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo('posts', 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('users', 'user_id', 'id');
    }
}
