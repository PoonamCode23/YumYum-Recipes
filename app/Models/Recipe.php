<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'image', 'ingredients', 'directions', 'time_required', 'servings', 'user_id', 'tags'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // this code is used to retrive id through user_id
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favourite::class);
    }
}
