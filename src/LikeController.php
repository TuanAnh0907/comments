<?php

namespace TuanAnh0907\Comments;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    private $like;

    public function __construct()
    {
        $LikeClass = Config::get('likes.model');
        $this->like = new $LikeClass;
    }

    public function like(Request $request)
    {
        $this->like->create([
            'user_id' => Auth::user()->id,
            'liker_type ' => $request->liker_type,
            'comment_id' => $request->comment_id
        ]);
        return Redirect::back();
    }

    public function dislike(Request $request)
    {
        $this->like->where([
            'user_id' => Auth::user()->id,
            'comment_id' => $request->comment_id
        ])->delete();
        return Redirect::back();
    }

    public function countLike($comment_id)
    {
        $value = $this->like->where([
            'comment_id' => $comment_id
        ])->count();

        return $value;
    }

    public function getLiker($comment_id)
    {
        $likers = DB::table('likes')->join('users', 'likes.user_id', '=', 'users.id')->where(
            'comment_id',
            $comment_id
        )->get();
        return $likers;
    }
}
