<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Filters\ThreadFilters;

class ThreadsController extends Controller
{
    /**
     * Create a new ThreadsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index' , 'show');
        $this->middleware('verified')->only('create' , 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel , ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel , $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index' , compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate(array(
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
        ));

        $thread = auth()->user()->addThread([
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
            'slug' => str_slug(request('title'))
        ]);

        return redirect($thread->path())
            ->with('flash' , 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  $channel_id
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel , Thread $thread)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        return view('threads.show' , compact('thread'));
    }

    /**
     * Delete the given thread.
     *
     * @param  \App\Thread  $thread
     * @param  $channel
     * @return mixed
     */
    public function destroy($channel , Thread $thread)
    {
        $this->authorize('update' , $thread);
        
        $thread->delete();

        if(request()->wantsJson()) {
            return response([] , 204);
        }

        return redirect('/threads');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param $channel
     * @param $filters
     * 
     * @return $threads
     */
    protected function getThreads($channel , $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id' , $channel->id);
        }

        return $threads->paginate(25);
    }
}
