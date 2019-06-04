<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Http\Requests\CreatePostRequest;

class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Fetch all relevant replies.
     *
     * @param  int $channelId
     * @param  Thread $thread
     */
    public function index($channelId , Thread $thread)
    {
        return $thread->replies()->paginate(15);
    }

    /**
     * Persist a new reply.
     *
     * @param  Thread  $thread
     * @param  int $channel_id
     * @param CreatePostRequest $form
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channel_id , Thread $thread , CreatePostRequest $form)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    /**
     * Update an existing reply.
     *
     * @param  Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update' , $reply);

        request()->validate(['body' => 'required|spamfree']);            

        $reply->update(request(['body']));
    }

    /**
     * Delete the given reply.
     *
     * @param  Reply $reply
     * @return Illuminate\Database\Eloquent\Model
     */
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
