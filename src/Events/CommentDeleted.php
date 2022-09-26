<?php

namespace TuanAnh0907\Comments\Events;

use Illuminate\Queue\SerializesModels;
use TuanAnh0907\Comments\Comment;

class CommentDeleted
{
    use SerializesModels;

    public $comment;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
