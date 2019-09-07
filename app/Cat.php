<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    protected $guarded = [];

    /**
     * define HasMany relationship
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
