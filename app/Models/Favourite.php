<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favourite extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'recipe_id'];


    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class); // this code is used to retrive id through user_id
    }
}
