<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{

    /**
     * FavoritesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Reply  $reply
     * @return back
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back()
            ->with('flash' , 'Favorite it');
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
