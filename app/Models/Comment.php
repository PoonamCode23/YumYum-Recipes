<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Like;



use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['recipe_id', 'user_id', 'ratings', 'comments'];

    public function user(): BelongsTo //use belongsTo class above
    {
        return $this->belongsTo(User::class); // this code is used to retrive id through user_id This method indicates that each comment belongs to a user based on the user_id foreign key in the comments table.
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
