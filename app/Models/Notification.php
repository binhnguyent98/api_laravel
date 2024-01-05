<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'description',
        'is_read',
        'type',
        'user_id'
    ];

    public function objectnable()
    {
        return $this->morphTo();
    }
}
