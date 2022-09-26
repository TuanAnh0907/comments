<?php

namespace TuanAnh0907\Comments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'liker_type',
        'comment_id',
    ];
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->morphTo();
    }

    /**
     * The model that was commented upon.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Returns the comment to which this comment belongs to.
     */
    public function parent()
    {
        return $this->belongsTo(Config::get('likes.model'), 'comment_id');
    }
}
