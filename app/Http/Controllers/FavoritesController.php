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
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        return $reply->favorite();
    }
}
