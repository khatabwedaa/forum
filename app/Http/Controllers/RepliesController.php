<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Reply;

class RepliesController extends Controller
{
    /**
     * RepliesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Thread  $thread
     * @param $channel_id
     * @return back
     */
    public function store($channel_id , Thread $thread)
    {
        request()->validate(array(
            'body' => 'required',
        ));
        
        $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()
            ->with('flash' , 'Your reply has been left!');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update' , $reply);
        
        $reply->delete();

        return back();
    }
}
