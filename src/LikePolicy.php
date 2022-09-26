<?php

namespace TuanAnh0907\Comments;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use TuanAnh0907\Comments\Comment;
use TuanAnh0907\Comments\Like;

class LikePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function like($user, Comment $comment): bool
    {
        $like = Like::where([
            'user_id' => Auth::user()->id,
            'comment_id' => $comment->getKey()
        ])->first();

        return $like ? false : true;
    }

    /**
     * @param $user
     * @param Comment $comment
     * @return bool
     */
    public function destroy($user, Comment $comment): bool
    {
        return $this->like($user, $comment) ? false : true;
    }
}
