<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Http\Requests\CreatePostRequest;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channelId , Thread $thread)
    {
        return $thread->replies()->paginate(15);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Thread  $thread
     * @param $channel_id
     * @return back
     */
    public function store($channel_id , Thread $thread , CreatePostRequest $form)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update' , $reply);

        try {
            request()->validate(['body' => 'required|spamfree']);            

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response(
                'Sorry your reply can not saved at this time' , 422
            );
        }
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update' , $reply);
        
        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply Deleted']);
        }

        return back();
    }
}
