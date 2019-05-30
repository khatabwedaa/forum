<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Inspections\Spam;

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
    public function store($channel_id , Thread $thread)
    {
        $this->validateReply();        
        
        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if(request()->expectsJson()) return $reply->load('owner');

        return back()
            ->with('flash' , 'Your reply has been left!');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update' , $reply);

        $this->validateReply();

        $reply->update(request(['body']));
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

    protected function validateReply()
    {
        request()->validate(['body' => 'required']);

        resolve(Spam::class)->detect(request('body'));
    }
}
