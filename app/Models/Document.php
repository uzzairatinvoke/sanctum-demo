<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Document extends Model
{

    protected $fillable = ['title', 'content', 'user_id'];
    // belongsTo a User

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
