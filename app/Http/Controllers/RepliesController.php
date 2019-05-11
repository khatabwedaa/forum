<?php

namespace App\Http\Controllers;

use App\Thread;

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

        return back();
    }
}
